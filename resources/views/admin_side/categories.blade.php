@extends('layouts.admin')

@section('main-content')

<div class="main-content ml-60 p-8 bg-slate-50 min-h-screen">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-800 flex items-center">
            <i class="fa fa-layer-group mr-2 text-indigo-500"></i>
            Manage Categories
        </h1>
        <button data-modal-target="addCategoryModal"
            class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold px-4 py-2 rounded-xl shadow hover:from-indigo-600 hover:to-purple-700 transition">
            <i class="fa fa-plus mr-2"></i>Add Category
        </button>
    </div>

    <!-- Card -->
    <div class="rounded-3xl bg-white/90 backdrop-blur-md border border-slate-200 shadow-xl transition-all">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold text-lg rounded-t-3xl px-5 py-3 flex items-center">
            <i class="fa fa-list mr-2"></i>
            Category List
        </div>

        <!-- Card Body -->
        <div class="p-6 space-y-4">
            <!-- Search -->
            <div class="relative w-1/4">
                <input type="text" id="searchCategory"
                    class="pl-10 pr-4 py-2 border border-slate-300 rounded-xl w-full text-slate-700 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition"
                    placeholder="Search Category...">
                <span class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fa fa-search"></i>
                </span>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full border-collapse rounded-2xl overflow-hidden shadow-sm bg-white text-slate-700 table-auto">
                    <thead class="bg-slate-100 text-slate-600 font-semibold text-sm">
                        <tr class="text-center">
                            <th class="p-3">No.</th>
                            <th class="p-3"><i class="fa fa-tag mr-1"></i>Category Name</th>
                            <th class="p-3"><i class="fa fa-calendar mr-1"></i>Created At</th>
                            <th class="p-3"><i class="fa fa-cog mr-1"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoryTableBody" class="text-center">
                        <tr>
                            <td colspan="4" class="py-4 text-gray-500">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav class="flex justify-center mt-5">
                <ul id="categoryPagination" class="flex space-x-2">
                    <li>
                        <button
                            class="flex items-center justify-center min-w-[32px] min-h-[32px] bg-slate-100 text-indigo-500 font-bold rounded-xl shadow-sm hover:bg-gradient-to-r hover:from-indigo-400 hover:to-sky-400 hover:text-white transition transform hover:-translate-y-0.5">
                            <i class="fa fa-chevron-left"></i>
                        </button>
                    </li>
                    <!-- JS will append page buttons here -->
                    <li>
                        <button
                            class="flex items-center justify-center min-w-[32px] min-h-[32px] bg-slate-100 text-indigo-500 font-bold rounded-xl shadow-sm hover:bg-gradient-to-r hover:from-indigo-400 hover:to-sky-400 hover:text-white transition transform hover:-translate-y-0.5">
                            <i class="fa fa-chevron-right"></i>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>



<!-- Add Category Modal -->
<div id="addCategoryModal"
    class="hidden fixed inset-0 bg-slate-800/50 backdrop-blur-sm flex items-center justify-center z-50 transition">

    <div class="bg-white/95 rounded-2xl w-11/12 md:w-3/4 lg:w-1/2 shadow-xl border border-slate-200 flex flex-col max-h-[90vh]">

        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-t-2xl flex-shrink-0">
            <h2 class="text-lg font-semibold text-white flex items-center">
                <i class="fa fa-plus-circle text-green-200 mr-2"></i>
                Add Category with Words
            </h2>
            <button data-modal-close class="text-white/80 hover:text-white">
                <i class="fa fa-times text-lg"></i>
            </button>
        </div>

        <!-- Scrollable Body -->
        <div class="overflow-y-auto px-6 py-5 space-y-5 flex-grow">
            <form id="addCategoryForm" class="space-y-5">

                <!-- Category Name -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Category Name</label>
                    <input type="text" id="category_name" name="category_name"
                        class="w-full border border-slate-300 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition"
                        placeholder="Enter category name" required>
                </div>

                <!-- Words Table -->
                <div>
                    <h6 class="font-semibold text-slate-700 flex items-center mb-2">
                        <i class="fa fa-language text-indigo-500 mr-2"></i>Words
                    </h6>
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table class="w-full text-sm text-slate-700">
                            <thead class="bg-slate-100 text-slate-600 uppercase font-semibold text-xs">
                                <tr>
                                    <th class="p-3 text-left">Tagalog Word</th>
                                    <th class="p-3 text-left">Example Sentence</th>
                                    <th class="p-3 text-left">English Translation</th>
                                    <th class="p-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="addWordsTableBody" class="bg-white divide-y divide-slate-100">
                                <tr>
                                    <td class="p-2">
                                        <input type="text" name="tagalog[]" class="w-full border border-slate-300 rounded-lg px-2 py-1 focus:ring-1 focus:ring-indigo-400 focus:outline-none" placeholder="Tagalog word" required>
                                    </td>
                                    <td class="p-2">
                                        <input type="text" name="sentence[]" class="w-full border border-slate-300 rounded-lg px-2 py-1 focus:ring-1 focus:ring-indigo-400 focus:outline-none" placeholder="Example sentence" required>
                                    </td>
                                    <td class="p-2">
                                        <input type="text" name="english[]" class="w-full border border-slate-300 rounded-lg px-2 py-1 focus:ring-1 focus:ring-indigo-400 focus:outline-none" placeholder="English translation" required>
                                    </td>
                                    <td class="text-center p-2">
                                        <button type="button" class="text-red-600 hover:text-red-800 transition remove-word">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Add Word Button -->
                    <div class="mt-3">
                        <button type="button" id="addWordBtn"
                            class="px-3 py-1.5 text-sm border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-100 transition flex items-center">
                            <i class="fa fa-plus mr-1 text-indigo-500"></i>Add Word
                        </button>
                    </div>
                </div>

                <!-- Reviewer Module -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Reviewer Module</label>
                    <textarea id="reviewer_text" name="reviewer_text" rows="5"
                        class="w-full border border-slate-300 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition"
                        placeholder="Write a paragraph explaining this category..." required></textarea>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="flex justify-end border-t border-slate-200 px-6 py-4 flex-shrink-0 bg-white/90 rounded-b-2xl">
            <button type="submit" form="addCategoryForm"
                class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium px-5 py-2 rounded-xl shadow hover:from-indigo-600 hover:to-purple-700 transition">
                <i class="fa fa-check mr-2"></i>Add
            </button>
        </div>
    </div>
</div>


<!-- Edit Category Modal -->
<div id="editCategoryModal"
    class="hidden fixed inset-0 bg-slate-800/50 backdrop-blur-sm flex items-center justify-center z-50 transition">

    <div class="bg-white/95 rounded-2xl w-11/12 md:w-3/4 lg:w-1/2 shadow-xl border border-slate-200 flex flex-col max-h-[90vh]">

        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-t-2xl flex-shrink-0">
            <h2 class="text-lg font-semibold text-white flex items-center">
                <i class="fa fa-edit mr-2 text-green-200"></i>
                Edit Category
            </h2>
            <button data-modal-close class="text-white/80 hover:text-white">
                <i class="fa fa-times text-lg"></i>
            </button>
        </div>

        <!-- Scrollable Body -->
        <div class="overflow-y-auto px-6 py-5 space-y-5 flex-grow">
            <form id="editCategoryForm" class="space-y-5">
                <input type="hidden" id="editCategoryId" name="category_id">

                <!-- Category Name -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Category Name</label>
                    <input type="text" id="editCategoryName" name="category_name"
                        class="w-full border border-slate-300 rounded-xl px-3 py-2 text-slate-800
                                focus:ring-2 focus:ring-indigo-400 focus:outline-none transition"
                        placeholder="Enter category name" required>
                </div>

                <!-- Words Section -->
                <div>
                    <h6 class="font-semibold text-slate-700 flex items-center mb-2">
                        <i class="fa fa-language text-indigo-500 mr-2"></i>Words
                    </h6>
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table class="w-full text-sm text-slate-700">
                            <thead class="bg-slate-100 text-slate-600 uppercase font-semibold text-xs">
                                <tr>
                                    <th class="p-3 text-left">Tagalog Word</th>
                                    <th class="p-3 text-left">Example Sentence</th>
                                    <th class="p-3 text-left">English Translation</th>
                                    <th class="p-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="wordsTableBody" class="bg-white divide-y divide-slate-100">
                                <!-- Dynamically inserted rows -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Add Word Button -->
                    <div class="mt-3">
                        <button type="button" id="addWordBtn_update"
                            class="px-3 py-1.5 text-sm border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-100 transition flex items-center">
                            <i class="fa fa-plus mr-1 text-indigo-500"></i>Add Word
                        </button>
                    </div>
                </div>

                <!-- Reviewer Module -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Reviewer Module</label>
                    <textarea id="editReviewerModule" name="reviewer_text" rows="6"
                        class="w-full border border-slate-300 rounded-xl px-3 py-2 text-slate-800
                                focus:ring-2 focus:ring-indigo-400 focus:outline-none transition"
                        placeholder="Write a paragraph explaining this category..." required></textarea>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="flex justify-end border-t border-slate-200 px-6 py-4 flex-shrink-0 bg-white/90 rounded-b-2xl">
            <button type="submit" form="editCategoryForm"
                class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium px-5 py-2 rounded-xl shadow hover:from-indigo-600 hover:to-purple-700 transition">
                <i class="fa fa-save mr-2"></i>Save changes
            </button>
        </div>
    </div>
</div>




@endsection
