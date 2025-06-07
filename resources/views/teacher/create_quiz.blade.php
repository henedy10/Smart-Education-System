<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>إنشاء اختبار جديد</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="max-w-4xl mx-auto p-6">
    <div class="bg-white p-6 rounded-2xl shadow-md">
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">📝 إنشاء اختبار جديد</h2>

      <form>
        <!-- عنوان الاختبار -->
        <div class="mb-4">
          <label class="block mb-2 text-sm font-medium text-gray-700">عنوان الاختبار</label>
          <input type="text" placeholder="مثال: اختبار نهاية الفصل" class="w-full p-3 rounded-lg border border-gray-300" />
        </div>

        <!-- وصف الاختبار -->
        <div class="mb-4">
          <label class="block mb-2 text-sm font-medium text-gray-700">الوصف</label>
          <textarea rows="3" placeholder="معلومات عن الاختبار..." class="w-full p-3 rounded-lg border border-gray-300"></textarea>
        </div>

        <!-- اختيار المادة -->
        <div class="mb-4">
          <label class="block mb-2 text-sm font-medium text-gray-700">اختر المادة</label>
          <select class="w-full p-3 rounded-lg border border-gray-300">
            <option disabled selected>اختر المادة</option>
            <option>الرياضيات</option>
            <option>اللغة العربية</option>
            <option>العلوم</option>
          </select>
        </div>

        <!-- موعد الامتحان -->
        <div class="mb-4">
          <label class="block mb-2 text-sm font-medium text-gray-700">موعد الامتحان</label>
          <input type="datetime-local" class="w-full p-3 rounded-lg border border-gray-300" />
        </div>

        <!-- مدة الامتحان -->
        <div class="mb-4">
          <label class="block mb-2 text-sm font-medium text-gray-700">مدة الامتحان (بالدقائق)</label>
          <input type="number" min="1" placeholder="مثال: 60" class="w-full p-3 rounded-lg border border-gray-300" />
        </div>

        <!-- الأسئلة -->
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-2">الأسئلة</h3>
          <div id="questions-container" class="space-y-4">
            <!-- سؤال واحد افتراضي -->
            <div class="question bg-gray-50 p-4 rounded-lg border">
              <label class="block text-sm font-medium text-gray-700 mb-1">نص السؤال</label>
              <input type="text" placeholder="ما هي عاصمة مصر؟" class="w-full p-2 rounded border" />

              <div class="grid grid-cols-2 gap-3 mt-3">
                <div>
                  <label class="block text-sm">الإجابة 1</label>
                  <input type="text" class="w-full p-2 rounded border" />
                </div>
                <div>
                  <label class="block text-sm">الإجابة 2</label>
                  <input type="text" class="w-full p-2 rounded border" />
                </div>
                <div>
                  <label class="block text-sm">الإجابة 3</label>
                  <input type="text" class="w-full p-2 rounded border" />
                </div>
                <div>
                  <label class="block text-sm">الإجابة 4</label>
                  <input type="text" class="w-full p-2 rounded border" />
                </div>
              </div>

              <div class="mt-3">
                <label class="block text-sm font-medium">الإجابة الصحيحة</label>
                <select class="w-full p-2 rounded border">
                  <option>الإجابة 1</option>
                  <option>الإجابة 2</option>
                  <option>الإجابة 3</option>
                  <option>الإجابة 4</option>
                </select>
              </div>

              <!-- زر حذف السؤال -->
              <button type="button" onclick="removeQuestion(this)" class="mt-4 px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                ❌ حذف السؤال
              </button>
            </div>
          </div>

          <!-- زر إضافة سؤال -->
          <button type="button" onclick="addQuestion()" class="mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
            ➕ إضافة سؤال جديد
          </button>
        </div>

        <!-- زر إرسال -->
        <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold">
          ✅ إنشاء الاختبار
        </button>
      </form>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    function addQuestion() {
      const container = document.getElementById("questions-container");
      const firstQuestion = container.querySelector(".question");

      const newQuestion = firstQuestion.cloneNode(true);
      newQuestion.querySelectorAll("input").forEach(input => input.value = "");
      newQuestion.querySelector("select").selectedIndex = 0;

      container.appendChild(newQuestion);
    }

    function removeQuestion(button) {
      const container = document.getElementById("questions-container");
      const questions = container.querySelectorAll(".question");

      if (questions.length > 1) {
        const questionToRemove = button.closest(".question");
        questionToRemove.remove();
      } else {
        alert("لا يمكن حذف جميع الأسئلة! يجب أن يحتوي الاختبار على سؤال واحد على الأقل.");
      }
    }
  </script>
</body>
</html>
