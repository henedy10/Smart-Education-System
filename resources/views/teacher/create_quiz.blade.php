@extends('teacher.layout.app')

@section('title') الاختبارات @endsection

@section('content')
<body class="min-h-screen">
                    @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
  <div class="max-w-5xl bg-gray-200  mx-auto py-10 px-4">
    <div class="bg-white p-6 rounded-2xl shadow-md">
        <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
            <h1 class="text-lg font-bold text-gray-800">إنشاء اختبار جديد</h1>
            <a href="{{route('show_teacher')}}" class="text-white bg-red-600 rounded px-6 py-2 hover:bg-red-700">الصفحة السابقة</a>
        </div>

      <form method="POST" action="{{route('store_teacher',$TeacherId)}}">
        @csrf
        <!-- عنوان الاختبار -->
        <div class="mb-4">
          <label class="block mb-2 text-sm font-medium text-gray-700">عنوان الاختبار</label>
          <input type="text" name="quiz_title" placeholder="مثال: اختبار نهاية الفصل" class="w-full p-3 rounded-lg border border-gray-300" />
        </div>

        <!-- وصف الاختبار -->
        <div class="mb-4">
          <label class="block mb-2 text-sm font-medium text-gray-700">الوصف</label>
          <textarea rows="3" type="text" name="quiz_description" placeholder="معلومات عن الاختبار..." class="w-full p-3 rounded-lg border border-gray-300"></textarea>
        </div>

        <!-- موعد الامتحان -->
        <div class="mb-4">
          <label class="block mb-2 text-sm font-medium text-gray-700">موعد الامتحان</label>
          <input type="datetime-local" name="quiz_date" class="w-full p-3 rounded-lg border border-gray-300" />
        </div>

        <!-- مدة الامتحان -->
        <div class="mb-4">
          <label class="block mb-2 text-sm font-medium text-gray-700">مدة الامتحان (بالدقائق)</label>
          <input type="number" name="quiz_duration" min="1" placeholder="مثال: 60" class="w-full p-3 rounded-lg border border-gray-300" />
        </div>

        <!-- الأسئلة -->
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-2">الأسئلة</h3>
          <div id="questions-container" class="space-y-4">
            <!-- سؤال واحد افتراضي -->
            <div class="question bg-gray-50 p-4 rounded-lg border">
              <label class="block text-sm font-medium text-gray-700 mb-1">نص السؤال</label>
              <input type="text" name="question_title[]" placeholder="ما هي عاصمة مصر؟" class="w-full p-2 rounded border" />

              <div class="grid grid-cols-2 gap-3 mt-3">
                <div>
                  <label class="block text-sm" >الإجابة 1</label>
                  <input type="text" name="option_title[]" class="w-full p-2 rounded border" />
                </div>
                <div>
                  <label class="block text-sm" >الإجابة 2</label>
                  <input type="text" name="option_title[]" class="w-full p-2 rounded border" />
                </div>
                <div>
                  <label class="block text-sm" >الإجابة 3</label>
                  <input type="text" name="option_title[]" class="w-full p-2 rounded border" />
                </div>
                <div>
                  <label class="block text-sm">الإجابة 4</label>
                  <input type="text" name="option_title[]" class="w-full p-2 rounded border" />
                </div>
              </div>

            <div class="mt-3">
                <label class="block text-sm font-medium">الإجابة الصحيحة</label>
                <select class="w-full p-2 rounded border" name="correct_option[]">
                    <option value="الإجابة 1">الإجابة 1</option>
                    <option value="الإجابة 2">الإجابة 2</option>
                    <option value="الإجابة 3">الإجابة 3</option>
                    <option  value="الإجابة 4">الإجابة 4</option>
                </select>
            </div>

            <!-- درجة كل سؤال  -->
            <div class="mt-4">
                <label class="block mb-2 text-sm font-medium text-gray-700">درجة السؤال</label>
                <input type="number" name="question_mark[]" min="1" placeholder="مثال: 2" class="w-full p-3 rounded-lg border border-gray-300" />
            </div>

              <!-- زر حذف السؤال -->
              <button type="button" onclick="removeQuestion(this)" class="mt-4 px-3 py-2 bg-red-500 text-white  rounded hover:bg-red-600">
                 حذف السؤال
              </button>
            </div>
          </div>

          <!-- زر إضافة سؤال -->
          <button type="button" name="add_question" onclick="addQuestion()" class="mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
             إضافة سؤال جديد
          </button>
        </div>

        <!-- زر إرسال -->
        <button type="submit"  name="upload" value="create_quiz"  class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold">
          إنشاء الاختبار
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

@endsection

