var $ = jQuery.noConflict();
jQuery(document).ready(function($) {
    var siteUrl = $('meta[name="site_url"]').attr('content') ? $('meta[name="site_url"]').attr('content') : "";
    var app = {
        xhrs: {},
        base_api: `${siteUrl}/wp-json/wp/v2`
    };

    app.utils = (function() {
        function parseQueryParams(url) {
            var params = {};
            var parser = document.createElement('a');
            parser.href = url;
            var query = parser.search.substring(1);
            var vars = query.split('&');
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split('=');
                params[pair[0]] = decodeURIComponent(pair[1]);
            }
            return params;
        };

        function formatDate(date) {
            var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'Novenber', 'December'];
            var d = new Date(date),
                month = '' + d.getMonth(),
                day = '' + d.getDate(),
                year = d.getFullYear();

            // if (month.length < 2)
            //     month = '0' + month;
            // if (day.length < 2)
            //     day = '0' + day;

            return `${monthNames[month]} ${day}, ${year}`;
            // return [month, day, year].join('/');
        }

        function getApiCall(url = "/", queryParams = {}, body = {}, name = "search") {
            return new Promise((resolve, reject) => {
                if (app.xhrs[name] !== undefined && app.xhrs[name] !== null) {
                    app.xhrs[name].abort();
                }

                var params = [];
                if (queryParams.constructor === Object && Object.keys(queryParams).length > 0) {
                    for (var key in queryParams) {
                        if (queryParams[key] != "undefined") {
                            params.push(key + '=' + queryParams[key]);
                        }
                    }
                }

                var apiUrl = `${app.base_api}${url}?${params.length > 0 ? params.join('&') : ""}`;

                app.xhrs[name] = $.post({
                    url: apiUrl,
                    data: JSON.stringify(body),
                    dataType: "json",
                    contentType: 'application/json; charset=utf-8',
                }).done(function(data) {
                    resolve(data);
                }).fail(function(error) {
                    reject(error)
                }).always(function() {
                    app.xhrs[name] = null;
                });
            });
        }
		
		function newGetApiCall(url = "/", queryParams = {}, body = {}, name = "search") {
            return new Promise((resolve, reject) => {
                if (app.xhrs[name] !== undefined && app.xhrs[name] !== null) {
                    app.xhrs[name].abort();
                }

                var params = [];
                if (queryParams.constructor === Object && Object.keys(queryParams).length > 0) {
                    for (var key in queryParams) {
                        if (queryParams[key] != "undefined") {
                            params.push(key + '=' + queryParams[key]);
                        }
                    }
                }

                var apiUrl = `${app.base_api}${url}?${params.length > 0 ? params.join('&') : ""}`;

                app.xhrs[name] = $.get({
                    url: apiUrl,
                    dataType: "json",
                    contentType: 'application/json; charset=utf-8',
                }).done(function(data) {
                    resolve(data);
                }).fail(function(error) {
                    reject(error)
                }).always(function() {
                    app.xhrs[name] = null;
                });
            });
        }

        return {
            parseQueryParams,
            getApiCall,
            formatDate,
			newGetApiCall
        };
    })($);

    app.search = (function() {
        var cache = {};
        var activeTab = null;
        var activeSubTab = null;
        var preloader = `<div class="loading-overlay">
          <div class="loading">
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
          </div>
        </div>`;
        var noResult = `<div class="card document no-result">
          <div class="card-body py-4 px-4">
            <div class="w-100 text-center">
              <h3 class="text-dark document-title text-center p-0 mt-0 mb-5 mx-0">No Result Found</h3>
            </div>
          </div>
        </div>`;

        function init() {
            cacheSelectors();

            cache.$documentTabs.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                cache.$documentTabs.removeClass('active');
                $(this).addClass('active');
                var target = $(this).attr('href');
                dataTab = $(this).attr('data-tab') ? $(this).attr('data-tab') : null;
                
                if(dataTab !== activeTab) {
                  activeTab = dataTab;
                  cache.$documentPanels.fadeOut('fast', function() {
                    setTimeout(function() {
                        $('.search--page .document-type-panels .document-type-panel' + target + '-panel').fadeIn('fast');
                    }, 200);
                  });
                  search();
                }
            });

            cache.$filters.children('.filter-title').on('click', function() {
                var _this = $(this);
                _this.parent().toggleClass("collapsed");
                _this.parent().find('.filter--body').slideToggle('fast');
            });

            cache.$filterApplyBtn.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                search();
            });

            cache.$filterClrBtn.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                clearFilters();
                search();
            });

            cache.$searchBtn.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                search();
            });

            cache.$searchInput.on('keypress', function(e) {
                if (e.which == 13) {
                    search();
                    return false;
                }
            });

            cache.$filtersHeader.on('click', function() {
              cache.$filters.slideToggle('fast');
              cache.$filtersFooter.slideToggle('fast');
            });

            $( window ).resize(function() {
              if (window.matchMedia('(min-width: 768px)').matches) {
                cache.$filters.slideDown('fast');
                cache.$filtersFooter.slideDown('fast');
              }
            });

            $(document).on('click', '.search--page .search--body .document-type-panels .document-type-panel .panel-footer ul.pages li', function() {
              if($(this).hasClass('active')) {
                return false;
              }
              search($(this).attr('data-page'));
            });

            $(document).on('click', '.search--page .search--body .search--results .document-type-panel .panel-header ul.document-sub-type-tabs li a', function(e) {
              e.preventDefault();
              e.stopPropagation();
              if($(this).hasClass('active')) {
                return false;
              }
              $('.search--page .search--body .search--results .document-type-panel .panel-header ul.document-sub-type-tabs li a').removeClass('active');
              $(this).addClass('active');

              activeSubTab = $(this).attr('data-tab') ? $(this).attr('data-tab') : "all";
              
              search();
            });

            search();
        }

        function cacheSelectors() {
            cache = {
                $page: $(".search--page"),
                $documentTabs: $(".search--page .document-type-tabs li a"),
                $documentPanels: $(".search--page .document-type-panels .document-type-panel"),
                $searchResultCount: $(".search--page .search-filters span.item-count span"),
                $filtersHeader: $(".search--page .search--body .search--filters .filter--header"),
                $filters: $(".search--page .search--body .search--filters .filter--wrapper"),
                $filtersFooter: $(".search--page .search--body .search--filters .filter--footer"),
                $filterApplyBtn: $(".search--page .search--filters .filter--footer button.apply--btn"),
                $filterClrBtn: $(".search--page .search--filters .filter--footer button.clear--btn"),
                $searchInput: $(".search--page input[name='search-input']"),
                $searchBtn: $(".search--page button.search--btn"),
                $searchedTerm: $(".search--page .searched-term"),
                $totalResult: $(".search--page .total--result span.total--result-count")
            };
        }

        async function search(page = 1) {
            var $resultContainer = getActiveContainer();
            var params = ((cache.$searchInput.val()).trim()).length > 0 ? { q: (cache.$searchInput.val()).trim() } : app.utils.parseQueryParams(window.location.href);
            if(activeTab !== null) {
              params.doc_type = activeTab;
            }
            if(activeTab === 'article' && activeSubTab && activeSubTab !== 'all') {
              params.doc_sub_type = activeSubTab;
            }
            params.page = page;
            var filters = getFilters();

            cache.$searchedTerm.text(params.q ? params.q : "");

            try {
                $resultContainer.children('.panel-body').html(preloader);
					var results = await app.utils.getApiCall("/search", params, {
                    filters
                }, 'search');
                
                renderResults(results.data);
            } catch (error) {
                console.log(error);
            }
        }

        function getFilters() {
            var filters = {};
            cache.$filters.each(function() {
                var _this = $(this);
                var filterName = _this.attr('data-filter');
                var $checked = _this.find(".filter--body ul li input[type='checkbox']:checked");
                var ids = [];
                if ($checked.length > 0) {
                    $checked.each(function() {
                        var val = Number($(this)[0].value);
                        if (val > 0) {
                            ids.push(val)
                        }
                    });
                }
                if (ids.length > 0) {
                    filters[filterName] = ids;
                }
            });

            return filters;
        }

        function clearFilters() {
            cache.$filters.each(function() {
                var _this = $(this);
                var $checked = _this.find(".filter--body ul li input[type='checkbox']:checked");
                if ($checked.length > 0) {
                    $checked.each(function() {
                        $(this).prop('checked', false);
                    });
                }
            });
        }

        function getActiveContainer() {
          var containerIds = {
            all: 'all',
            article: 'articles',
            event: 'events',
            software: 'softwares',
            news: 'news',
            company: 'companies'
          }
          return $(`.search--page .search--body .search--results .document-type-panels .document-type-panel#${containerIds[activeTab ? activeTab : 'all']}-panel`);
        }

        function renderResults(data) {
          var $resultContainer = getActiveContainer();
          var rows = [];
          cache.$totalResult.text(`${Number(data.pagination.totalDocuments)}`);
          if (data.documents.length > 0) {
              data.documents.forEach((post) => {
                  var row = `
                  <div class="card mb-4">
                    <div class="card-body pt-0 pb-4 px-0">
                      <div class="d-flex align-items-center justify-content-center">
                        <img src="${post.featured_image ? post.featured_image : `https://kairos.blvckpixel.com/wp-content/uploads/2020/12/no-image-3.jpg`}" class="feat-img" alt="${post.post_title}" />
                      </div>
                      <div class="hc-lh-sm ml-3 ml-lg-0">
                        <a href="${siteUrl}/${post.post_type}/${post.post_name}">
                          <h3 class="m-0 hc-fs-36 hc-fw-700 hc-color-primary">
                            ${post.post_title}
                          </h3>
                        </a>
                        <span class="hc-fs-18 hc-fw-400">Emilie Pourier | ${app.utils.formatDate(post.post_modified)}</span>

                        <p class="d-none d-lg-block card-text my-4 hc-lh-base">${post.post_content}</p>
                        <div class="d-none d-lg-block">
                          <span class="hc-fs-18 text-uppercase">
                            <span class="hc-color-secondary">${post.business_sectors.length ? post.business_sectors.join(", ") : ''}</span> / <span>${post.post_type}</span> / <span>${post.domains.length ? post.domains.join(", ") : ''}</span>
                          </span>
                        </div>
                      </div>
                      <div class="d-block d-lg-none">
                        <p class="card-text my-4 hc-lh-base">${post.post_content}</p>
                        <div>
                          <span class="hc-fs-18 text-uppercase">
                            <span class="hc-color-secondary">${post.business_sectors.length ? post.business_sectors.join(", ") : ''}</span> / <span>${post.post_type}</span> / <span>${post.domains.length ? post.domains.join(", ") : ''}</span>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                `;

                rows.push(row);
              });
          }
          $resultContainer.children('.panel-body').html(rows.length > 0 ? rows.join("") : noResult);
          $resultContainer.find('.panel-footer span.total').html(`Page ${Number(data.pagination.totalPages) > 0 ? data.pagination.currentPage : 0}/${data.pagination.totalPages}`);

          var $pages = [];
          if(Number(data.pagination.totalPages) > 1) {
            for(var i=1; i<=data.pagination.totalPages; i++) {
              $pages.push(`
                <li class="${i == data.pagination.currentPage ? 'active' : ''}" data-page="${i}">${i}</li>
              `)
            }
          }
          $resultContainer.find('.panel-footer ul.pages').html($pages.join(""));
        }

        return {
            init: init,
            search: search
        };
    })($);

    app.search.init();
});