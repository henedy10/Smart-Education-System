<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>الأسئلة - الاختبار</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <div class="max-w-4xl mx-auto p-6 mt-10 bg-white rounded-xl shadow-md">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-blue-600">الأسئلة - اختبار: <span class="text-gray-800">الرياضيات</span></h1>
      <span class="text-sm text-gray-600">الوقت المتبقي: <span id="timer" class="font-bold text-red-600">10:00</span></span>
    </div>

    <form action="#" method="POST">

      <!-- سؤال 1 -->
      <div class="mb-6">
        <p class="font-semibold text-lg mb-2">1. ما ناتج 5 × 3؟</p>
        <div class="space-y-2">
          <label class="block">
            <input type="radio" name="answers[1]" value="option_1" class="mr-2"> 8
          </label>
          <label class="block">
            <input type="radio" name="answers[1]" value="option_2" class="mr-2"> 15
          </label>
          <label class="block">
            <input type="radio" name="answers[1]" value="option_3" class="mr-2"> 10
          </label>
        </div>
      </div>

      <!-- سؤال 2 -->
      <div class="mb-6">
        <p class="font-semibold text-lg mb-2">2. ما هي عاصمة مصر؟</p>
        <div class="space-y-2">
          <label class="block">
            <input type="radio" name="answers[2]" value="option_1" class="mr-2"> الإسكندرية
          </label>
          <label class="block">
            <input type="radio" name="answers[2]" value="option_2" class="mr-2"> القاهرة
          </label>
          <label class="block">
            <input type="radio" name="answers[2]" value="option_3" class="mr-2"> الجيزة
          </label>
        </div>
      </div>

      <button type="submit" class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
        إرسال الإجابات
      </button>
    </form>
  </div>

  <!-- عداد تنازلي بسيط -->
  <script>
    let duration = 10 * 60; // 30 دقيقة
    const timerDisplay = document.getElementById('timer');

    setInterval(() => {
      const minutes = Math.floor(duration / 60);
      const seconds = duration % 60;
      timerDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
      if (duration > 0) duration--;
    }, 1000);
  </script>
</body>
</html>
