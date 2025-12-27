@extends('layouts.dashboard')

@section('title', 'Create Course')

@push('styles')
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
            background-color: #f9fafb !important;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-6xl  mx-auto py-6 px-10 rounded-md">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create a Course</h1>
        </div>

        <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-8 bg-gray-50 border border-gray-200 rounded-lg p-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Course Title</label>
                    <input type="text" name="title"
                        class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none"
                        placeholder="Enter course title" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Course category</label>
                    <input type="text" name="category"
                        class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none"
                        placeholder="Enter course category" required>
                </div>

            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-3 rounded-md bg-gray-50 border border-gray-200 text-gray-900 outline-none"
                    placeholder="Describe your course..."></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Feature Video</label>
                <input type="file" name="feature_video"
                    class="w-full   rounded-lg bg-gray-50 border border-gray-200 text-gray-900 file:mr-4 file:py-4 file:px-4 file:rounded-l-md file:border-0 file:text-sm file:font-semibold file:bg-blue-800 file:text-white hover:file:bg-blue-900 transition-all outline-none"
                    accept="video/*" required>
            </div>

            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <button type="button" id="addModuleBtn"
                        class="px-4 py-3 bg-blue-800 hover:bg-blue-900 text-white text-sm font-medium rounded-md flex items-center gap-2 ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Add Module
                    </button>
                </div>

                <div id="modulesWrapper" class="space-y-6">
                </div>
            </div>


            <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                <button type="submit"
                    class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-md">
                    Save
                </button>
                <button type="reset" class="px-5 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-md">
                    Cancel
                </button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

    <script>
        let editor;
        ClassicEditor
            .create(document.querySelector('#description'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote',
                    'undo', 'redo'
                ],
            })
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => {
                console.error(error);
            });
        $('form').on('submit', function() {
            if (editor) {
                const data = editor.getData();
                $('#description').val(data);
            }
        });



        let moduleIndex = 0;
        $("#addModuleBtn").click(function() {
            let moduleHtml = `
                <div class="module-box bg-gray-50 rounded-xl border border-gray-200 overflow-hidden shadow-sm transition-all hover:shadow-md">
                    <!-- Module Header -->
                    <div class="bg-gray-100 px-6 py-4 flex justify-between items-center border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800">Module ${moduleIndex + 1}</h3>
                        <button type="button" class="removeModule p-1.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Module Title</label>
                            <input type="text" name="modules[${moduleIndex}][title]"
                                class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none"
                                placeholder="Enter module title" required>
                        </div>


                        <div class="contentsWrapper space-y-4"> </div>

                        <div class="pt-2">
                            <button type="button"
                                class="addContentBtn px-4 py-3 bg-blue-800 hover:bg-blue-900 text-white text-sm font-semibold rounded-md flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Add Content
                            </button>
                        </div>
                    </div>
                </div>
            `;

            $("#modulesWrapper").append(moduleHtml);
            moduleIndex++;
        });

        $(document).on("click", ".removeModule", function() {
            $(this).closest(".module-box").fadeOut(200, function() {
                $(this).remove();
            });
        });

        $(document).on("click", ".addContentBtn", function() {
            let wrapper = $(this).closest(".module-box").find(".contentsWrapper");
            let contentIndex = wrapper.children().length;
            let currentModuleIndex = $(this).closest(".module-box").find("input[name^='modules']").attr("name")
                .match(/modules\[(\d+)\]/)[1];

            let contentHtml = `
                <div class="content-box bg-white rounded-md border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-5 py-3 flex justify-between items-center border-b border-gray-200">
                        <div>
                            <p class="font-bold text-gray-700 text-sm">Content</p>
                        </div>
                        <button type="button" class="removeContent p-1 text-gray-400 hover:text-red-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-5 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Content Title</label>
                                <input type="text" name="modules[${currentModuleIndex}][contents][${contentIndex}][title]"
                                    class="w-full px-3 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none text-sm"
                                    placeholder="Enter content title" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Video Source Type</label>
                                <select name="modules[${currentModuleIndex}][contents][${contentIndex}][type]"
                                    class="w-full px-3 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none text-sm">
                                    <option value="youtube">YouTube</option>
                                    <option value="vimeo">Vimeo</option>
                                    <option value="file">Upload File</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Video URL</label>
                                <input type="text" name="modules[${currentModuleIndex}][contents][${contentIndex}][value]"
                                    class="w-full px-3 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none text-sm"
                                    placeholder="https://youtube.com/...">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Video Length</label>
                                <input type="text" name="modules[${currentModuleIndex}][contents][${contentIndex}][length]"
                                    class="w-full px-3 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none text-sm"
                                    placeholder="HH:MM:SS">
                            </div>
                        </div>
                    </div>
                </div>
            `;

            wrapper.append(contentHtml);
        });

        $(document).on("click", ".removeContent", function() {
            $(this).closest(".content-box").fadeOut(200, function() {
                $(this).remove();
            });
        });
    </script>
@endpush
