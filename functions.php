<?php
include_once "config.php";
include_once "Parsedown.php";
$parsedown = new Parsedown();
/**
 * @param $string string
 * @param $startString string
 * @return bool
 */
function startsWith($string, $startString) {
    return (substr($string, 0, strlen($startString)) === $startString);
}

/**
 * @param $image string
 * @param $title string
 * @param $subtitle string
 * @param $shoppyID string
 * @param $darktheme number|bool
 * @param $plugin number
 *
 * $plugin=1 | drystone
 * $plugin=2 | matchheight
 */
function createCard($image, $title, $subtitle, $shoppyID, $darktheme, $plugin) {
    if (!isset($stock)) {
        include_once "ini_functions.php";
        $stock = parse_ini("stock.ini")['stock'];
    }
    if (!isset($parsedown)) {
        $parsedown = new Parsedown();
    }
//    $title = str_replace("\n", "<br>", $title);
//    $subtitle = str_replace("\n", "<br>", htmlentities($subtitle));
    $title = $parsedown->text($title);
    $subtitle = $parsedown->text($subtitle);
    if (isset($stock[$shoppyID])) {
        $inStock = $stock[$shoppyID];
        if ($inStock <= 0) {
            $stock_html = "<h6 class=\"text-center text-danger card-subtitle mb-1 mb-0 stock_warning text-truncate\">current out of stock</h6>";
            $stockdepenent_footer_html = "<div class=\"card-footer\"><button class=\"btn btn-primary btn-block\" disabled='disabled' type=\"button\" data-shoppy-product=\"${shoppyID}\">Purchase</button></div>";
        } else {
            $stock_html = "<h6 class=\"text-center text-muted card-subtitle mt-1 mb-0 stock_warning text-truncate\">${inStock} currently in stock</h6>";
            $stockdepenent_footer_html = "<div class=\"card-footer\"><button class=\"btn btn-primary btn-block\" type=\"button\" data-shoppy-product=\"${shoppyID}\">Purchase</button></div>";
        }
    } else {
        $stock_html = "<!-- NO STOCK SET -->";
        $stockdepenent_footer_html = "<div class=\"card-footer\"><button class=\"btn btn-primary btn-block\" type=\"button\" data-shoppy-product=\"${shoppyID}\">Purchase</button></div>";
    }
    $themeclasses = $darktheme === 1 || $darktheme === true ? "text-white bg-dark" : ($darktheme === 0 || $darktheme === false ? "text-dark bg-white" : "text-dark bg-white");
    $packageclasses = $plugin === 1 ? "" : ($plugin === 2 ? "col-lg-6 col-xl-4" : "col-lg-6 col-xl-4");
//    col-lg-6 col-xl-4
    echo <<<HEREDOC
<div class="${packageclasses} package" style="margin-top: 1rem;">
    <div class="card ${themeclasses}" data-bs-hover-animate="pulse">
        <div class="card-body text-center">
            <p class="text-center"><img class="img-fluid" src="${image}"></p>
            <h3 class="text-center card-title">${title}</h3>
            <h6 class="text-center text-muted card-subtitle mb-2">${subtitle}</h6>
            ${stock_html}
        </div>
        ${stockdepenent_footer_html}
    </div>
</div>
HEREDOC;
}

/**
 * @param $path string
 */
function embedMusic($path) {
    $result = preg_replace('/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/', '$5', $path);
    if (!empty($result) || !isset($result)) {
        echo "<iframe style=\"visibility: hidden;\" width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/${result}?controls=0;autoplay=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>";
    }
}