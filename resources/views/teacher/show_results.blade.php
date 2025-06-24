@extends('teacher.layout.app')

@section('title') نتائج الطلاب @endsection

@section('content')

<body class="min-h-screen">

  <div class="container mx-auto p-6 bg-gray-100">
    <div class="bg-white rounded-xl shadow-md p-6">

    <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
      <h2 class="text-lg font-bold text-gray-800">نتائج الطلاب</h2>
      <a href="{{route('show_teacher')}}" class="text-white bg-green-600 rounded px-6 py-2 hover:bg-green-700">الصفحة السابقة</a>
    </div>
      <!-- ✅ فلتر حسب الاختبار -->
      <div class="flex flex-col sm:flex-row  items-center gap-4 mb-6">
        <div>
          <select id="quizFilter" class="border border-gray-300 rounded p-2 w-full sm:w-64">
            <option value="all">كل الاختبارات</option>
            <option value="امتحان الفصل الأول">امتحان الفصل الأول</option>
            <option value="امتحان القراءة">امتحان القراءة</option>
            <option value="امتحان النحو">امتحان النحو</option>
          </select>
        </div>
        <button onclick="filterTable()"
                class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
          فلترة
        </button>
      </div>

      <!-- ✅ جدول النتائج -->
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-right text-gray-700 border border-gray-200 rounded">
          <thead class="bg-blue-100 text-blue-800">
            <tr>
              <th class="p-3 border border-gray-200">#</th>
              <th class="p-3 border border-gray-200">اسم الطالب</th>
              <th class="p-3 border border-gray-200">الاختبار</th>
              <th class="p-3 border border-gray-200">الدرجة</th>
              <th class="p-3 border border-gray-200">من</th>
              <th class="p-3 border border-gray-200">تاريخ التقديم</th>
            </tr>
          </thead>
          <tbody id="resultsTable">
            <tr data-quiz="امتحان الفصل الأول" class="hover:bg-gray-50 transition">
              <td class="p-3 border">1</td>
              <td class="p-3 border">أحمد محمد</td>
              <td class="p-3 border">امتحان الفصل الأول</td>
              <td class="p-3 border text-green-600 font-semibold">8</td>
              <td class="p-3 border">10</td>
              <td class="p-3 border">2025-06-01 10:30</td>
            </tr>
            <tr data-quiz="امتحان القراءة" class="hover:bg-gray-50 transition">
              <td class="p-3 border">2</td>
              <td class="p-3 border">سارة علي</td>
              <td class="p-3 border">امتحان القراءة</td>
              <td class="p-3 border text-green-600 font-semibold">9</td>
              <td class="p-3 border">10</td>
              <td class="p-3 border">2025-06-03 14:00</td>
            </tr>
            <tr data-quiz="امتحان النحو" class="hover:bg-gray-50 transition">
              <td class="p-3 border">3</td>
              <td class="p-3 border">محمود يوسف</td>
              <td class="p-3 border">امتحان النحو</td>
              <td class="p-3 border text-green-600 font-semibold">7</td>
              <td class="p-3 border">10</td>
              <td class="p-3 border">2025-06-04 09:00</td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </div>

  <!-- ✅ JavaScript للفلترة -->
  <script>
    function filterTable() {
      const selectedQuiz = document.getElementById('quizFilter').value;
      const rows = document.querySelectorAll('#resultsTable tr');

      rows.forEach(row => {
        const quiz = row.getAttribute('data-quiz');
        if (selectedQuiz === 'all' || quiz === selectedQuiz) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }
  </script>
</body>

@endsection
