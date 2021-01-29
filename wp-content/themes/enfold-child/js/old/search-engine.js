var $ = jQuery.noConflict();

jQuery(document).ready(function($) {
            var app = {
                xhrs: {},
                base_api: "https://kairos.blvckpixel.com/api/v1"
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
                    var d = new Date(date),
                        month = '' + (d.getMonth() + 1),
                        day = '' + d.getDate(),
                        year = d.getFullYear();

                    if (month.length < 2)
                        month = '0' + month;
                    if (day.length < 2)
                        day = '0' + day;

                    return [month, day, year].join('/');
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

                        app.xhrs[name] = $.get({
                            url: apiUrl,
                            dataType: "json",
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
                    formatDate
                };
            })($);

            app.search = (function() {
                var cache = {};

                function init() {
                    cacheSelectors();

                    if (cache.$page.length > 0) {
                        cache.$documentTabs.on('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            cache.$documentTabs.removeClass('active');
                            $(this).addClass('active');
                            var target = $(this).attr('href');
                            cache.$documentPanels.fadeOut('fast', function() {
                                setTimeout(function() {
                                    $('.search-page-body .document-type-panels .document-type-panel' + target + '-panel').fadeIn('fast');
                                }, 200);
                            });
                        });
                    }

                    search();
                }

                function cacheSelectors() {
                    cache = {
                        $page: $(".search-page-body"),
                        $documentTabs: $(".search-page-body .document-type-tabs li a"),
                        $documentPanels: $(".search-page-body .document-type-panels .document-type-panel"),
                        $searchResultCount: $(".search-page-body .search-filters span.item-count span")
                    };
                }

                async function search() {
                    var params = app.utils.parseQueryParams(window.location.href);

                    try {
                        $('#all-panel').html('<img src="https://i.imgur.com/055wrlu.gif" />');
                        $('#articles-panel').html('<img src="https://i.imgur.com/055wrlu.gif" />');
                        var results = await app.utils.getApiCall("/search", params, {}, 'search');
                        cache.$searchResultCount.text(results.data.length);
                        var rows = [];
                        var articles = [];
                        if (results.data.length > 0) {
                            results.data.forEach((item) => {
                                var post = item._source;
                                var row = `<div class="card document mb-4">
                                <div class="card-body py-4 px-4">
                                  <div>
                                    <h3 class="text-dark document-title">${post.post_title}</h3>
                                    <p class="card-text">${post.post_content}</p>
                                    <div class="card-footer d-flex flex-wrap p-0">
                                      <span class="font-weight-bold text-truncate d-block"><a href="#">${post.article_types.length ? post.article_types[0] : 'NA'}</a></span>
                                      <span class="mx-3">-</span>
                                      <span class="font-weight-bold text-truncate d-block"><a href="#">${post.authors.length ? post.authors[0] : 'NA'}</a></span>
                                      <span class="mx-3">-</span>
                                      <span class="font-weight-bold text-truncate d-block"><a href="#">${post.domains.length ? post.domains.join(", ") : 'NA'}</a></span> 
                                      <span class="mx-3">-</span>
                                      <span class="font-weight-bold text-dark d-block">${app.utils.formatDate(post.post_modified)}</span>
                                    </div>
                                  </div>
                                  <div class="d-flex align-items-center justify-content-center">
                                    <img src="https://via.placeholder.com/200x150" alt="placeholder" />
                                  </div>
                                </div>
                              </div>
                            `;
                                rows.push(row);
                                if (post.post_type == 'article') {
                                    articles.push(row);
                                }
                            });
                        } else {
                            rows.push(`
                        <div class="card document">
                          <div class="card-body py-4 px-4">
                            <div>
                              <h3 class="text-dark document-title text-center">No Result Found</h3>
                            </div>
                          </div>
                        </div>
                      `);
                        }

                        $('#all-panel').html(rows.join(""));
                        $('#articles-panel').html(rows.join(""));
                        console.log(results);
                    } catch (error) {
                        console.log(error);
                    }
                }

                return {
                    init: init,
                    search: search
                };
            })($);
            
            app.search.init();
        });