<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>تسجيل طالب - نظام الاختبارات</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white shadow-lg rounded-xl w-full max-w-md p-6 space-y-6">
    <h2 class="text-2xl font-bold text-center text-gray-800">تسجيل طالب</h2>

    <form action="student-dashboard.html" method="POST" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">الاسم الكامل</label>
        <input type="text" name="name" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

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

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">الصف الدراسي</label>
        <select name="grade"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">اختر الصف</option>
          <option value="1">الصف الأول</option>
          <option value="2">الصف الثاني</option>
          <option value="3">الصف الثالث</option>
          <!-- زود الصفوف حسب النظام عندك -->
        </select>
      </div>

      <button type="submit"
              class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-200">
        تسجيل
      </button>
    </form>

    <p class="text-center text-sm text-gray-600">
      لديك حساب بالفعل؟ <a href="/" class="text-blue-600 hover:underline">سجل الدخول</a>
    </p>
  </div>

</body>
</html>
