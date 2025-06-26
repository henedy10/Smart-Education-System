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
                {{-- <th class="px-4 py-2 border">درجه الواجب</th>
              <th class="px-4 py-2 border">رابط  حلول الطلاب</th>
              <th class="px-4 py-2 border">الحالة</th>
              <th class="px-4 py-2 border">إجراء</th> --}}
            </tr>
          </thead>
          <tbody>
            <!-- واجب 1 -->
            {{-- @foreach ($homeworks as $homework ) --}}
            <tr class="hover:bg-gray-50 transition">
              <td class="px-4 py-2 border">3</td>
              <td class="px-4 py-2 border">3</td>
              <td class="px-4 py-2 border "><input type="number" class="border border-amber-600 w-full p-2" min="0"></td>
              {{--<td class="px-4 py-2 border">g</td>
               <td class="px-4 py-2 border text-blue-600 underline cursor-pointer">
                <form action="#" method="POST">
                    @csrf
                    <button type="submit" value="3">اضغط هنا</button>
                </form>
              </td>
              <td class="px-4 py-2 border text-yellow-600 font-semibold">قيد التصحيح</td>
              <td class="px-4 py-2 border">
                <button onclick="markReviewed(this)" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                  تم التصحيح
                </button>
              </td> --}}
            </tr>
            {{-- @endforeach --}}
            <!-- المزيد هنا -->
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
