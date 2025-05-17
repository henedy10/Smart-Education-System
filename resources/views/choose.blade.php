<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>اختيار نوع التسجيل - نظام الاختبارات</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white shadow-xl rounded-xl w-full max-w-md p-8 text-center space-y-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">اختر نوع التسجيل</h2>
    <p class="text-gray-600">يرجى اختيار نوع الحساب الذي ترغب في إنشائه:</p>

    <div class="flex flex-col gap-4 mt-6">
      <a href="{{route('create_student')}}"
         class="block w-full py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-200">
        تسجيل كطالب
      </a>

      <a href="{{route('create_teacher')}}"
         class="block w-full py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition duration-200">
        تسجيل كمدرس
      </a>
    </div>

    <p class="text-sm text-gray-600 mt-6">
      لديك حساب بالفعل؟ <a href="{{route('index')}}" class="text-blue-600 hover:underline">سجل الدخول من هنا</a>
    </p>
  </div>

</body>
</html>
