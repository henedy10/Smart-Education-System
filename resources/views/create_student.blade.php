<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>تسجيل طالب - نظام الاختبارات</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white shadow-lg rounded-xl w-full max-w-md p-6 space-y-6">
    <h2 class="text-2xl font-bold text-center text-gray-800">تسجيل طالب</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <form action="{{route('store_student')}}" method="POST" class="space-y-4">
        @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">الاسم الكامل</label>
        <input type="text" name="name"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
        <input type="email" name="email"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور</label>
        <input type="password" name="password"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">الصف الدراسي</label>
        <select name="grade"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">اختر الصف</option>
          <option value="الصف الأول">الصف الأول</option>
          <option value="الصف الثاني">الصف الثاني</option>
          <option value="الصف الثالث">الصف الثالث</option>
          <!-- زود الصفوف حسب النظام عندك -->
        </select>
      </div>

      <button type="submit"
              class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-200"
              value="student"
              name="user_as">
        تسجيل
      </button>
    </form>

    <p class="text-center text-sm text-gray-600">
      لديك حساب بالفعل؟ <a href="/" class="text-blue-600 hover:underline">سجل الدخول</a>
    </p>
  </div>

</body>
</html>
