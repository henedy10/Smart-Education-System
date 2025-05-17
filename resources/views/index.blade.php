<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>تسجيل الدخول - نظام الاختبارات</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white shadow-lg rounded-xl w-full max-w-md p-6 space-y-6">
    <h2 class="text-2xl font-bold text-center text-gray-800">تسجيل الدخول</h2>

    <form action="#" method="#" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
        <input type="email" name="email" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور</label>
        <input type="password" name="password" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div class="flex items-center justify-between">
        <label class="inline-flex items-center">
          <input type="checkbox" class="form-checkbox text-blue-600">
          <span class="ml-2 text-sm text-gray-600">تذكرني </span>
        </label>
        <a href="#" class="text-sm text-blue-600 hover:underline">نسيت كلمة المرور؟</a>
      </div>

      <button type="submit"
              class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
        دخول
      </button>
    </form>

    <p class="text-center text-sm text-gray-600">
      ليس لديك حساب؟ <a href="#" class="text-blue-600 hover:underline">سجل الآن</a>
    </p>
  </div>

</body>
</html>
