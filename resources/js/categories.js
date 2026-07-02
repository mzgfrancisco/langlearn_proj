import $ from 'jquery';
import Swal from 'sweetalert2';

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});

$(document).ready(function () {

    // Load categories
    function loadCategories(keyword = '', page = 1, limit = 10) {
        $.ajax({
            url: "/admin/categories/all",
            method: "GET",
            dataType: "json",
            data: {
                keyword: keyword,
                page: page,
                limit: limit
            },
            success: function (response) {
                let tbody = $("#categoryTableBody");
                tbody.empty();

                // -------------------------
                // Render Category Rows
                // -------------------------
                if (response.success && response.data.length > 0) {
                    let count = (page - 1) * limit;

                    response.data.forEach(function (row) {
                        // Format created_at
                        let formattedDateCategory = "N/A";
                        if (row.created_at) {
                            let dateObj = new Date(row.created_at);
                            let optionsDate = { year: "numeric", month: "long", day: "numeric" };
                            let optionsTime = { hour: "numeric", minute: "2-digit", hour12: true };
                            let datePart = dateObj.toLocaleDateString("en-US", optionsDate);
                            let timePart = dateObj.toLocaleTimeString("en-US", optionsTime);
                            formattedDateCategory = `${datePart} - ${timePart}`;
                        }

                        count++;
                        tbody.append(`
                            <tr class="text-center hover:bg-slate-50 transition">
                                <td class="py-2 font-medium">${count}</td>
                                <td class="py-2">${row.category_name}</td>
                                <td class="py-2 text-slate-600">${formattedDateCategory}</td>
                                <td class="py-2">
                                    <div class="flex justify-center gap-2">
                                        <button
                                            class="bg-yellow-400/90 hover:bg-yellow-500 text-white text-sm px-2 py-1 rounded-lg shadow-sm transition edit-category-btn"
                                            data-id="${row.id}"
                                            data-name="${row.category_name}"
                                            data-modal-target="editCategoryModal"
                                            title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button
                                            class="bg-red-500/90 hover:bg-red-600 text-white text-sm px-2 py-1 rounded-lg shadow-sm transition delete-category-btn"
                                            data-id="${row.id}"
                                            title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    tbody.html(`
                        <tr>
                            <td colspan="4" class="py-5 text-center text-slate-500">
                                No categories found
                            </td>
                        </tr>
                    `);
                }

                // -------------------------
                // Pagination Section
                // -------------------------
                let pagination = $("#categoryPagination");
                pagination.empty();

                if (response.total_pages > 1) {
                    // Previous button
                    let prevDisabled = (response.current_page === 1) ? "opacity-50 pointer-events-none" : "";
                    pagination.append(`
                        <button
                            class="page-link px-3 py-1 mx-1 bg-slate-200 rounded-lg text-slate-700 font-semibold hover:bg-indigo-100 transition ${prevDisabled}"
                            data-page="${response.current_page - 1}">
                            <i class="fa fa-chevron-left"></i>
                        </button>
                    `);

                    // Page numbers
                    for (let i = 1; i <= response.total_pages; i++) {
                        let active = (i === response.current_page)
                            ? "bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-md"
                            : "bg-slate-200 text-slate-700 hover:bg-indigo-100";

                        pagination.append(`
                            <button
                                class="page-link px-3 py-1 mx-1 rounded-lg font-semibold transition ${active}"
                                data-page="${i}">
                                ${i}
                            </button>
                        `);
                    }

                    // Next button
                    let nextDisabled = (response.current_page === response.total_pages) ? "opacity-50 pointer-events-none" : "";
                    pagination.append(`
                        <button
                            class="page-link px-3 py-1 mx-1 bg-slate-200 rounded-lg text-slate-700 font-semibold hover:bg-indigo-100 transition ${nextDisabled}"
                            data-page="${response.current_page + 1}">
                            <i class="fa fa-chevron-right"></i>
                        </button>
                    `);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error loading categories:", error);
                console.log("Response:", xhr.responseText);
                $("#categoryTableBody").html(`
                    <tr>
                        <td colspan="4" class="py-5 text-center text-red-500">
                            Failed to load categories.
                        </td>
                    </tr>
                `);
            }
        });
    }



    // Add category
    $("#addCategoryForm").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: "/admin/categories/add",
            method: "POST",
            dataType: "json",
            data: {
                category_name: $("#category_name").val(),
                reviewer_text: $("#reviewer_text").val(),
                english: $("input[name='english[]']").map(function () { return $(this).val(); }).get(),
                tagalog: $("input[name='tagalog[]']").map(function () { return $(this).val(); }).get(),
                sentence: $("input[name='sentence[]']").map(function () { return $(this).val(); }).get()
            },
            success: function (response) {
                if (response.success) {
                    $("#addCategoryForm")[0].reset();
                    $("#addCategoryModal").addClass("hidden").removeClass("flex");
                    loadCategories();
                    Swal.fire("Success", "Category added successfully", "success");
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let message = Object.values(errors).flat().join('\n');
                    Swal.fire("Validation Error", message, "warning");
                } else {
                    Swal.fire("Error", "Failed to add category", "error");
                }
                console.error(xhr.responseText);
            }
        });
    });

    // Edit category (load details)
    function editCategory(id) {
        $.ajax({
            url: "/admin/categories/get",
            method: "POST",
            dataType: "json",
            data: { id: id },
            success: function (data) {
                if (data.success) {
                    $("#editCategoryId").val(data.category.id);
                    $("#editCategoryName").val(data.category.category_name);
                    $("#editReviewerModule").val(data.category.module);

                    let wordsHtml = "";
                    data.words.forEach(function (word) {
                        wordsHtml += `
                            <tr class="transition hover:bg-slate-50">
                                <td class="p-2">
                                    <input type="text"
                                        name="tagalog[]"
                                        value="${word.tagalog_word}"
                                        class="w-full border border-slate-300 rounded-lg px-2 py-1 text-slate-800
                                            focus:ring-1 focus:ring-indigo-400 focus:outline-none transition"
                                        placeholder="Tagalog word" required>
                                </td>
                                <td class="p-2">
                                    <input type="text"
                                        name="sentence[]"
                                        value="${word.example_sentence}"
                                        class="w-full border border-slate-300 rounded-lg px-2 py-1 text-slate-800
                                            focus:ring-1 focus:ring-indigo-400 focus:outline-none transition"
                                        placeholder="Example sentence" required>
                                </td>
                                <td class="p-2">
                                    <input type="text"
                                        name="english[]"
                                        value="${word.english_word}"
                                        class="w-full border border-slate-300 rounded-lg px-2 py-1 text-slate-800
                                            focus:ring-1 focus:ring-indigo-400 focus:outline-none transition"
                                        placeholder="English word" required>
                                </td>
                                <td class="text-center p-2">
                                    <button type="button"
                                            class="text-red-600 hover:text-red-800 transition remove-word-edit">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });

                    $("#wordsTableBody").html(wordsHtml);
                    $("#editCategoryModal").modal("show");
                } else {
                    Swal.fire("Error", "Failed to load category data", "error");
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    $(document).on("click", ".edit-category-btn", function () {
        editCategory($(this).data("id"));
    });

    // Update category
    $("#editCategoryForm").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: "/admin/categories/update",
            method: "POST",
            dataType: "json",
            data: {
                category_id: $("#editCategoryId").val(),
                category_name: $("#editCategoryName").val(),
                reviewer_text: $("#editReviewerModule").val(),
                english: $("input[name='english[]']").map(function () { return $(this).val(); }).get(),
                tagalog: $("input[name='tagalog[]']").map(function () { return $(this).val(); }).get(),
                sentence: $("input[name='sentence[]']").map(function () { return $(this).val(); }).get()
            },
            success: function (response) {
                if (response.success) {
                    $("#editCategoryForm")[0].reset();
                    $("#editCategoryModal").addClass("hidden").removeClass("flex");
                    loadCategories();
                    Swal.fire("Success", "Category added successfully", "success");
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function (xhr) {
                Swal.fire("Error", "Update failed", "error");
                console.error(xhr.responseText);
            }
        });
    });

    // Delete category
    $(document).on("click", ".delete-category-btn", function () {
        let id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "This category will be deleted permanently.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Delete"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/admin/categories/delete",
                    method: "POST",
                    dataType: "json",
                    data: { id: id },
                    success: function (response) {
                        if (response.success) {
                            loadCategories();
                            Swal.fire("Deleted", "Category removed", "success");
                        } else {
                            Swal.fire("Error", response.message, "error");
                        }
                    },
                    error: function (xhr) {
                        Swal.fire("Error", "Failed to delete category", "error");
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });

    // Pagination click handler
    $(document).on("click", "#categoryPagination a.page-link", function (e) {
        e.preventDefault();
        let page = $(this).data("page");
        if (page) {
            loadCategories($("#searchCategory").val(), page);
        }
    });

    // Initial load
    loadCategories();




    // --------------------------
    // Word Input Logic
    // --------------------------
    let wordCount = $("#addWordsTableBody tr").length;
    const maxWords = 10;

    // Add Word (Add Modal)
    $(document).on("click", "#addWordBtn", function (e) {
        e.preventDefault();

        if (wordCount < maxWords) {
            wordCount++;
            $("#addWordsTableBody").append(`
                <tr class="transition hover:bg-slate-50">
                    <td class="p-2">
                        <input type="text"
                            name="tagalog[]"
                            class="w-full border border-slate-300 rounded-lg px-2 py-1 text-slate-800 focus:ring-1 focus:ring-indigo-400 focus:outline-none transition"
                            placeholder="Tagalog word" required>
                    </td>
                    <td class="p-2">
                        <input type="text"
                            name="sentence[]"
                            class="w-full border border-slate-300 rounded-lg px-2 py-1 text-slate-800 focus:ring-1 focus:ring-indigo-400 focus:outline-none transition"
                            placeholder="Example sentence" required>
                    </td>
                    <td class="p-2">
                        <input type="text"
                            name="english[]"
                            class="w-full border border-slate-300 rounded-lg px-2 py-1 text-slate-800 focus:ring-1 focus:ring-indigo-400 focus:outline-none transition"
                            placeholder="English word" required>
                    </td>
                    <td class="text-center p-2">
                        <button type="button" class="text-red-600 hover:text-red-800 transition remove-word">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
            `);
        } else {
            Swal.fire({
                title: "Limit Reached",
                text: "Maximum 10 words only",
                icon: "warning",
                confirmButtonColor: "#3085d6"
            });
        }
    });

    // Add Word (Edit Modal)
    $(document).on("click", "#addWordBtn_update", function (e) {
        e.preventDefault();

        const wordsTableBody = $("#wordsTableBody");
        const currentCount = wordsTableBody.find("tr").length;

        if (currentCount < maxWords) {
            wordsTableBody.append(`
                <tr class="transition hover:bg-slate-50">
                    <td class="p-2">
                        <input type="text"
                            name="tagalog[]"
                            class="w-full border border-slate-300 rounded-lg px-2 py-1 text-slate-800 focus:ring-1 focus:ring-indigo-400 focus:outline-none transition"
                            placeholder="Tagalog word" required>
                    </td>
                    <td class="p-2">
                        <input type="text"
                            name="sentence[]"
                            class="w-full border border-slate-300 rounded-lg px-2 py-1 text-slate-800 focus:ring-1 focus:ring-indigo-400 focus:outline-none transition"
                            placeholder="Example sentence" required>
                    </td>
                    <td class="p-2">
                        <input type="text"
                            name="english[]"
                            class="w-full border border-slate-300 rounded-lg px-2 py-1 text-slate-800 focus:ring-1 focus:ring-indigo-400 focus:outline-none transition"
                            placeholder="English word" required>
                    </td>
                    <td class="text-center p-2">
                        <button type="button" class="text-red-600 hover:text-red-800 transition remove-word">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
            `);
        } else {
            Swal.fire({
                title: "Limit Reached",
                text: "Maximum 10 words only",
                icon: "warning",
                confirmButtonColor: "#3085d6"
            });
        }
    });

    // Remove Word (shared)
    $(document).on("click", ".remove-word", function () {
        $(this).closest("tr").remove();
        wordCount = Math.max(0, wordCount - 1);
    });


    // --------------------------
    // Modal Open/Close (Shared)
    // --------------------------
    function openModal(modalId) {
        const modal = $("#" + modalId);
        $("body").addClass("overflow-hidden");
        modal.removeClass("hidden").addClass("flex opacity-0");

        setTimeout(() => {
            modal.removeClass("opacity-0").addClass("opacity-100 transition duration-300 ease-out");
        }, 10);
    }

    function closeModal(modalId) {
        const modal = $("#" + modalId);
        modal.removeClass("opacity-100").addClass("opacity-0 transition duration-200 ease-in");

        setTimeout(() => {
            modal.addClass("hidden").removeClass("flex");
            $("body").removeClass("overflow-hidden");
        }, 200);
    }

    // Open modal
    $(document).on("click", "[data-modal-target]", function () {
        openModal($(this).data("modal-target"));
    });

    // Close modal via button or outside click
    $(document).on("click", "[data-modal-close]", function () {
        closeModal($(this).closest(".fixed").attr("id"));
    });

    $(document).on("click", ".fixed", function (e) {
        if ($(e.target).is(".fixed")) {
            closeModal($(this).attr("id"));
        }
    });

    // Prevent modal content from closing modal
    $(document).on("click", ".fixed > div", function (e) {
        e.stopPropagation();
    });


});










