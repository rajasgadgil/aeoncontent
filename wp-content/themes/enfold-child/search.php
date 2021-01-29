<?php

/**
 * Template Name: Search Page
 *
 * @package OceanWP WordPress theme
 */

?>

<?php get_header(); ?>

<?php
$tabs = [
    ["id" => "all", "name" => "all", "text" => "All", "active" => true],
    [
        "id" => "articles",
        "name" => "article",
        "text" => "Articles",
        "active" => false,
        "children" => [
            ["name" => "All", "slug" => "all"],
            ["name" => esc_html__('Comparatif', 'teknow'), "slug" => "panorama"],
            ["name" => esc_html__('Guide', 'teknow'), "slug" => "guide"],
            ["name" => esc_html__('Enjeu', 'teknow'), "slug" => "challenge-enjeu"],
            ["name" => esc_html__('Tendance', 'teknow'), "slug" => "trend"],
            ["name" => esc_html__('Expérience client', 'teknow'), "slug" => "customer-experience-feedbackexperience-client"],
            ["name" => esc_html__('Connaissance marché', 'teknow'), "slug" => "market-knowledge-connaissance-marche"],
            ["name" => esc_html__('Livre blanc', 'teknow'), "slug" => "whitepaper-livre-blanc"],
            ["name" => esc_html__('Parcours', 'teknow'), "slug" => "journey-parcours"]
        ]
    ],
    ["id" => "events", "name" => "event", "text" => esc_html__('Events', 'teknow'), "active" => false],
    ["id" => "news", "name" => "news", "text" => esc_html__('News', 'teknow'), "active" => false],
    ["id" => "softwares", "name" => "software", "text" => esc_html__('Softwares', 'teknow'), "active" => false],
    ["id" => "companies", "name" => "company", "text" => esc_html__('Companies', 'teknow'), "active" => false]
];
?>

<div id="content-wrap" class="container-fluid clr px-0 hc-ff-roboto search--page">
    <div class="content-area clr">
        <section class="search--header pt-4 pb-5">
            <div class="container px-0 text-dark hc-fw-400">
                <div>
                    <div class="mb-3">
                        <span class="hc-fs-36"><?php echo esc_html__('You searched for', 'teknow'); ?>:</span>
                        <span class="searched-term hc-fs-36 hc-fw-700 hc-color-secondary"><?= isset($_GET['q']) ? $_GET['q'] : ""; ?></span>
                    </div>
                    <div class="align-items-end justify-content-start search-input--wrapper">
                        <span><?php echo esc_html__('Displaying', 'teknow'); ?> <span class="total--result hc-fw-700"><span class="total--result-count">0</span> <?php echo esc_html__('results', 'teknow'); ?></span> / <?php echo esc_html__('New search:', 'teknow'); ?>: </span>
                        <span class="search-input--container">
                            <input type="text" value="" name="search-input" class="w-100" />
                            <button class="search--btn">⌕</button>
                        </span>
                    </div>
                </div>
                <div class="d-flex align-items-end mt-4 mt-lg-0">
                    <span class="text-uppercase hc-fw-300" style="min-width: 75px;"><?php echo esc_html__('Trier par', 'teknow'); ?></span>
                    <select name="sort_by" class="form-control ml-auto hc-fw-400 hc-fs-20">
                        <option value="most_recent"><?php echo esc_html__('Most Recent ', 'teknow'); ?></option>
                    </select>
                </div>
            </div>
        </section>
        <section class="search--body pt-4 pb-5">
            <div class="container px-0 text-dark hc-fw-400">
                <div>
                    <ul class="nav d-flex flex-nowrap align-items-center justify-content-start document-type-tabs text-uppercase">
                        <?php foreach ($tabs as $tab) { ?>
                            <li class="nav-item flex-grow-1 p-0">
                                <a class="nav-link d-block w-100 text-center pb-3 hc-ff-roboto <?= $tab['active'] ? 'active' : ''; ?>" href="#<?= $tab['id']; ?>" data-tab="<?= $tab['name']; ?>"><?= $tab['text']; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="search--results mt-5">
                        <div class="document-type-panels">
                            <?php foreach ($tabs as $tab) { ?>
                                <div id="<?= $tab['id']; ?>-panel" class="document-type-panel <?= $tab['active'] ? 'active' : ''; ?>">
                                    <div class="panel-header">
                                        <?php if (isset($tab['children']) && is_array($tab['children'])) { ?>
                                            <ul class="nav d-flex flex-nowrap align-items-center justify-content-start document-sub-type-tabs mb-5 text-uppercase">
                                                <?php foreach ($tab['children'] as $key => $child) { ?>
                                                    <li class="nav-item flex-grow-1 p-0">
                                                        <a class="nav-link d-block w-100 text-center text-nowrap text-capitalize pb-3 hc-fs-18 hc-ff-roboto <?= $key === 0 ? 'active' : ''; ?>" href="#<?= $child['slug']; ?>" data-tab="<?= $child['slug']; ?>">
                                                            <?= esc_html__(explode("(", $child['name'])[0], 'teknow'); ?>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                    <div class="panel-body"></div>
                                    <div class="panel-footer">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between mt-5">
                                            <ul class="pages pages d-flex align-items-center justify-content-start hc-fs-20 mb-0"></ul>
                                            <span class="total hc-ff-roboto hc-fs-20 hc-fw-500"></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="search--filters mb-5">
                        <div class="d-flex d-lg-none align-items-center hc-lh-sm text-uppercase hc-bg-primary text-light mb-3 px-3 py-3 filter--header">
                            <i class="fas fa-sliders-h"></i><span class="ml-3 hc-fs-22">Filter Search for better results</span>
                        </div>
                        <div class="filter--wrapper mb-5 px-4 px-lg-0" data-filter="business_sectors">
                            <div class="filter-title text-uppercase hc-fs-23 hc-fw-400"><?php echo esc_html__('FILTER BY SECTOR', 'teknow'); ?></div>
                            <div class="filter--body">
                                <ul class="d-flex flex-column py-3">

                                    <?php

                                    echo return_taxonomylist('business_sector');
                                    ?>


                                </ul>
                            </div>
                        </div>

                        <div class="filter--wrapper mb-5 px-4 px-lg-0" data-filter="domains">
                            <div class="filter-title text-uppercase hc-fs-23 hc-fw-400"><?php echo esc_html__('FILTER BY DOMAIN', 'teknow'); ?></div>
                            <div class="filter--body">
                                <ul class="d-flex flex-column py-3">

                                    <?php
                                    echo return_taxonomylist('domain');
                                    ?>


                                </ul>
                            </div>
                        </div>
                        <div class="filter--wrapper mb-5 px-4 px-lg-0" data-filter="functions">
                            <div class="filter-title text-uppercase hc-fs-23 hc-fw-400"><?php echo esc_html__('FILTER BY FUNCTIONS', 'teknow'); ?></div>
                            <div class="filter--body">
                                <ul class="d-flex flex-column py-3">

                                    <?php
                                    echo return_taxonomylist('functions');
                                    ?>


                                </ul>
                            </div>
                        </div>

                        <div class="filter--footer px-4 px-lg-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <span><button class="filter--btn apply--btn text-uppercase hc-fw-100 hc-lh-1 px-4 py-3 hc-fs-18"><?php echo esc_html__('APPLY FILTERS', 'teknow'); ?></button></span>
                                <span><button class="filter--btn clear--btn text-uppercase hc-fw-100 hc-lh-1 px-4 py-3 hc-fs-18"><?php echo esc_html__('CLEAR FILTERS', 'teknow'); ?></button></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- ==================================== -->

<?php get_footer(); ?>