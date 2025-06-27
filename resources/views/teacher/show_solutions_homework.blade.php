<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تصحيح الواجبات</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  <div class="container mx-auto p-6">
    <div class="bg-white p-6 rounded-xl shadow-md">

    <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">

        <h1 class="text-lg font-bold text-gray-800">حلول الطلاب للواجبات</h1>
        <a href="{{route('correct_teacher_homework',$TeacherId)}}" class="text-white bg-red-600 rounded px-6 py-2 hover:bg-red-700">الصفحة السابقة</a>

    </div>

      <!-- جدول الواجبات -->
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 text-right text-sm">
          <thead class="bg-blue-100 text-blue-800">
            <tr>
                <th class="px-4 py-2 border">اسم الطالب</th>
                <th class="px-4 py-2 border">حل الطالب</th>
                <th class="px-4 py-2 border">درجه حل الطالب</th>
            </tr>
          </thead>
          <tbody>
              <!-- واجب 1 -->
              @foreach ($solutions as $solution )
            <tr class="hover:bg-gray-50 transition">
              <td class="px-4 py-2 border">{{$solution->student->user->name}}</td>
              <td class="px-4 py-2 border">
                <a href="{{asset('storage/'.$solution->homework_solution_file)}}" target="_blank"
                    class="bg-red-600 text-white px-3 py-1 ml-2 rounded hover:bg-red-500 text-sm">مشاهدة</a>
                <a href="{{asset('storage/'.$solution->homework_solution_file)}}" download target="_blank"
                    class="bg-blue-600 text-white px-3 py-1 ml-2 rounded hover:bg-blue-500 text-sm">تحميل</a>
            </td>
              <td class="px-4 py-2 border "><input type="number" class="border border-amber-600 w-full p-2" min="0" max="{{$solution->homework->homework_mark}}"></td>
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>

    </div>
  </div>

  <!-- JavaScript بسيط لتغيير الحالة -->
  <script>
    function markReviewed(button) {
      const row = button.closest("tr");
      const statusCell = row.querySelector("td:nth-child(6)");
      statusCell.innerText = "تم التصحيح";
      statusCell.classList.remove("text-yellow-600");
      statusCell.classList.add("text-green-600");
      button.disabled = true;
      button.classList.add("opacity-50", "cursor-not-allowed");
      button.innerText = "✓";
    }
  </script>

</body>
</html>
