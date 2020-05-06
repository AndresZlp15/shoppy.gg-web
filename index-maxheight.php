<?php
include "config.php";
include "functions.php";
if (is_array($background)) {
    $background = $background[array_rand($background, 1)];
}
$re = '/\.(mp4|webm)$/mi';
$str = $background;

preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
if (count($matches) > 0) {
    $background_css = "";
    if (pathinfo($background, PATHINFO_EXTENSION) === "webm") {
        $background_mimetype = "video/webm";
    } else {
        $background_mimetype = mime_content_type($background);
    }
    $background_html = <<<HTML
<video autoplay muted loop id="backgroundvideo">
<source src="${background}" type="${background_mimetype}">
</video>
HTML;
} else {
    if ($background_fix === 1) {
        $background_css = "background-image: url(${background});background-size: cover;background-repeat: no-repeat;background-size: 100%;background-attachment:fixed;";
    } else {
        $background_css = "background-image: url(${background});background-size: cover;background-repeat: no-repeat;background-position: center;";
    }
    $background_html = "";
}
$themeclasses = $darktheme === 1 || $darktheme === true ? "text-white bg-dark" : ($darktheme === 0 || $darktheme === false ? "text-dark bg-white" : "text-dark bg-white");
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="source.css" media="screen"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $name ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="shortcut icon" href="<?php echo $favicon ?>" type="images/x-icon"/>
</head>
<body style="<?php echo $background_css ?>">
<?php echo $background_html ?>

<div id="particles"></div>

<script src="particles.js" defer></script>

<div class="container">
    <div class="row justify-content-center rubberBand animated" style="margin-top: 0.5rem;">
        <div class="col-xl-9 text-center <?php echo $themeclasses ?>" style="border-radius: 10px;">
            <p style="margin-top: 1rem;margin-bottom: 1rem;"><i class="<?php echo $headericon ?>"></i>&nbsp;<?php echo htmlentities($name) ?>&nbsp;<i class="<?php echo $headericon ?>"></i></p>
        </div>
    </div>
    <div class="packages row justify-content-center" style="margin-top: 4rem;margin-bottom: 5rem;">
        <?php foreach ($cards as $card) {
            createCard($card[0], $card[1], $card[2], $card[3], $darktheme, 2);
        } ?>
    </div>
</div>
<?php if (!empty($youtubeMusicLink)) {
    embedMusic($youtubeMusicLink);
} ?>


<?php if ($discord): ?>
    <button type="button" style="position:fixed" class="btn btn-primary dbtn" data-toggle="modal" data-target="#exampleModalCenter">
        <i class="fab fa-discord"></i>
    </button>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="text-align:center; background-color: rgba(0,0,0,0); border:none ">
                <iframe src="<?php echo $discord ?>" width="350" height="500" allowtransparency="true" frameborder="0" style="margin-left: auto;margin-right: auto;"></iframe>
            </div>
        </div>
    </div>
<?php endif; ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="https://shoppy.gg/api/embed.js"></script>
<script src="assets/js/script-maxheight.min.js"></script>
</body>

</html>