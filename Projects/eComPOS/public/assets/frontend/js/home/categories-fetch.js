$.ajax({
    url: "/ajax-categories",
    type: "GET",
    success: function (response) {
        response.data.categories.forEach(function (category, index) {
            let html = "";

            if (category.child_categories.length > 0) {
                // Generate the subcategories HTML
                let subcategoriesHtml = "";
                category.child_categories.forEach(function (subcategory) {
                    subcategoriesHtml += `<li class="nav-item">
                                            <a href="/view-all-products/subcategory/${subcategory.slug}" class="nav-link category-link">
                                                <img src="${subcategory.thumbnail}" alt="menu" class="category-menu-icon">
                                                ${subcategory.name}
                                            </a>
                                        </li>`;
                });

                // Generate the collapsible category HTML
                html = `<div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button category-menu-item collapsed gap-2"
                                    type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-category-${index}" aria-expanded="false"
                                    aria-controls="flush-category-${index}">
                                    <img src="${category.thumbnail}" alt="menu"
                                        class="category-menu-icon">
                                    ${category.name}
                                </button>
                            </h2>
                            <div id="flush-category-${index}" class="accordion-collapse collapse"
                                data-bs-parent="#categorySectionSubmenu">
                                <div class="accordion-body">
                                    <ul class="nav flex-column">
                                        ${subcategoriesHtml}
                                    </ul>
                                </div>
                            </div>
                        </div>`;
            } else {
                // Use the provided HTML structure for non-collapsible categories
                html = `<div class="accordion-item">
                            <h2 class="accordion-header">
                                <a href="/view-all-products/category/${category.slug}" class="accordion-button category-menu-item collapsed gap-2 single-category-menu">
                                    <img src="${category.thumbnail}" alt="menu" class="category-menu-icon">
                                    ${category.name}
                                </a>
                            </h2>
                        </div>`;
            }

            // Append the generated HTML to the desired container
            $("#categorySectionSubmenu").append(html);
        });
    },
    error: function (xhr, status, error) {
        var response = JSON.parse(xhr.responseText);
        console.log(response.message);
    },
});
