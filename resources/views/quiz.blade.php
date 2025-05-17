<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>الاختبار - الطالب</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <div class="max-w-3xl mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6">

      <h1 class="text-2xl font-bold mb-6 text-blue-700 text-center">🧪 اختبار الرياضيات</h1>

      <form id="quizForm" class="space-y-6">

        <!-- سؤال 1 -->
        <div class="space-y-2">
          <p class="font-semibold">1. ما ناتج 7 × 8 ؟</p>
          <label class="block">
            <input type="radio" name="q1" value="40" class="mr-2" />
            40
          </label>
          <label class="block">
            <input type="radio" name="q1" value="56" class="mr-2" />
            56
          </label>
          <label class="block">
            <input type="radio" name="q1" value="64" class="mr-2" />
            64
          </label>
        </div>

        <!-- سؤال 2 -->
        <div class="space-y-2">
          <p class="font-semibold">2. ما هو الجذر التربيعي لـ 81 ؟</p>
          <label class="block">
            <input type="radio" name="q2" value="9" class="mr-2" />
            9
          </label>
          <label class="block">
            <input type="radio" name="q2" value="8" class="mr-2" />
            8
          </label>
          <label class="block">
            <input type="radio" name="q2" value="7" class="mr-2" />
            7
          </label>
        </div>

        <!-- سؤال 3 -->
        <div class="space-y-2">
          <p class="font-semibold">3. ما ناتج 12 ÷ 4 ؟</p>
          <label class="block">
            <input type="radio" name="q3" value="2" class="mr-2" />
            2
          </label>
          <label class="block">
            <input type="radio" name="q3" value="3" class="mr-2" />
            3
          </label>
          <label class="block">
            <input type="radio" name="q3" value="4" class="mr-2" />
            4
          </label>
        </div>

        <!-- زر الإرسال -->
        <div class="text-center pt-6">
          <button
            type="submit"
            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition"
          >
            إرسال الإجابات
          </button>
        </div>
      </form>

    </div>
  </div>

  <!-- JavaScript للمعالجة -->
  <script>
    document.getElementById("quizForm").addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(this);
      const answers = Object.fromEntries(formData.entries());

      console.log("إجابات الطالب:", answers);

      // تقدر تبعتها بـ fetch أو AJAX للباك إند هنا
      alert("تم إرسال إجاباتك بنجاح!");
    });
  </script>

</body>
</html>
