<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GeminaiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com';

    public function __construct()
    {
        $this->apiKey = env('GEMINAI_API_KEY');
    }

    /**
     * Summarize a file using Gemini AI.
     *
     * @param string $filePath Path to the file in storage.
     * @param string $mimeType Mime type of the file.
     * @return string
     */
    public function summarize(string $filePath, string $mimeType): string
    {
        try {
            // 1. Upload file to Gemini File API
            $uploadResult = $this->uploadFile($filePath, $mimeType);

            if (is_array($uploadResult) && isset($uploadResult['error'])) {
                return "Failed to upload file to Gemini: " . $uploadResult['error'];
            }

            $fileUri = $uploadResult;

            // 2. Generate summary
            return $this->generateSummary($fileUri, $mimeType);

        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * Upload file to Gemini File API.
     */
    protected function uploadFile(string $filePath, string $mimeType)
    {
        if (!Storage::disk('public')->exists($filePath)) {
            throw new \Exception("File not found in storage: " . $filePath);
        }

        $fileContent = Storage::disk('public')->get($filePath);
        $fileName = basename($filePath);

        $response = Http::withHeaders([
            'X-Goog-Upload-Protocol' => 'multipart',
        ])
            ->attach(
                'metadata',
                json_encode(['file' => ['display_name' => $fileName]]),
                'metadata.json',
                ['Content-Type' => 'application/json']
            )
            ->attach(
                'file',
                $fileContent,
                $fileName,
                ['Content-Type' => $mimeType]
            )->post("{$this->baseUrl}/upload/v1beta/files?key={$this->apiKey}");

        if ($response->successful()) {
            return $response->json('file.uri');
        }

        return ['error' => $response->body()];
    }

    /**
     * Generate summary using the uploaded file URI.
     */
    protected function generateSummary(string $fileUri, string $mimeType): string
    {
        $response = Http::post("{$this->baseUrl}/v1beta/models/gemini-2.5-flash:generateContent?key={$this->apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['file_data' => ['mime_type' => $mimeType, 'file_uri' => $fileUri]],
                        ['text' => 'Summarise this file in a clear and concise way for a student.']
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            return $response->json('candidates.0.content.parts.0.text') ?? "Could not generate summary.";
        }

        return "Error from Gemini API: " . $response->body();
    }
}
