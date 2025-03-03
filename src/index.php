<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POSSE 初めてのWeb制作</title>
    <!-- スタイルシート読み込み -->
    <link rel="stylesheet" href="./assets/styles/common.css">
    <!-- Google Fonts読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
    <script src="../assets/scripts/common.js" defer></script>
</head>

<body>
<header id="js-header" class="l-header p-header">
    <div class="p-header__logo"><img src="./assets/img/logo.svg" alt="POSSE"></div>
    <button class="p-header__button" id="js-headerButton"></button>
    <div class="p-header__inner">
        <nav class="p-header__nav">
            <ul class="p-header__nav__list">
                <li class="p-header__nav__item">
                    <a href="./" class="p-header__nav__item__link">POSSEとは</a>
                </li>
                <li class="p-header__nav__item">
                    <a href="./quiz.php" class="p-header__nav__item__link">クイズ</a>
                </li>
            </ul>
        </nav>
    <div class="p-header__official">
        <a href="https://line.me/R/ti/p/@651htnqp?from=page" target="_blank" rel="noopener noreferrer" class="p-header__official__link--line">
            <i class="u-icon__line"></i>
            <span class="">POSSE公式LINEを追加</span>
            <i class="u-icon__link"></i>
        </a>
        <a href="" class="p-header__official__link--website">POSSE 公式サイト<i class="u-icon__link"></i></a>
    </div>
    <div>
        <ul class="p-header__sns p-sns">
        <li class="p-sns__item">
            <a href="https://twitter.com/posse_program" target="_blank" rel="noopener noreferrer" class="p-sns__item__link"
            aria-label="Twitter">
            <i class="u-icon__twitter"></i>
            </a>
        </li>
        <li class="p-sns__item">
            <a href="https://www.instagram.com/posse_programming/" target="_blank" rel="noopener noreferrer"
                class="p-sns__item__link" aria-label="instagram">
                <i class="u-icon__instagram"></i>
            </a>
        </li>
        </ul>
    </div>
</header>
<!-- /.l-header .p-header -->

    <main class="l-main">
    <section class="p-top-hero">
        <div class="p-top-hero__inner">
        <div class="p-top-hero__body">
            <h1 class="p-top-hero__body__title">学生プログラミングコミュニティ POSSE（ポッセ）</h1>
            <span class="p-top-hero__body__catchcopy">自分史上最高<br>を仲間と。</span>
        </div>
        <picture class="p-top-hero__image">
            <img src="./assets/img/img-hero.jpg" alt="">
        </picture>
        <div class="p-top-hero__scroll">Scroll Down</div>
        </div>
    </section>
    <!-- /.p-top-hero -->

    <div class="p-top-container">
        <section class="l-section p-top-about">
        <div class="l-container">
            <h2 class="p-heading">
            POSSEとは<span class="p-heading__caption" lang="en" aria-hidden="true">About POSSE</span>
            </h2>
            <div class="p-top-about__body">
            <picture class="p-top-about__image">
                <img src="./assets/img/img-about.jpg" alt="POSSEメンバー集合写真">
            </picture>
            <div class="p-top-about__content">
                <p>
                学生プログラミングコミュニティ「POSSE(ポッセ)」は、人格とプログラミング、二つの面での成長をスローガンに活動しており、大学生だけが集まって学びを深めるコミュニティです。<br>プログラミングだけではありません。オフラインでのイベントや、旅行など様々な企画を行っています！<br>それらを通じて、夏休みの大半をPOSSEで出来た仲間と過ごす人もたくさんいるほどメンバーとの仲が深まります。
                </p>
            </div>
            </div>
        </div>
        </section>
    <!-- /.l-section p-top-about -->
    </div>
    </main>
    <!-- /.l-main -->

    <div class="p-line">
    <div class="l-container">
        <div class="p-line__body">
        <div class="p-line__body__inner">
            <h2 class="p-heading -light p-line__title"><i class="u-icon__line"></i>POSSE 公式LINE</h2>
            <div class="p-line__content">
            <p>公式LINEにてご質問を随時受け付けております。<br>詳細やPOSSE最新情報につきましては、公式LINEにてお知らせ致しますので<br>下記ボタンより友達追加をお願いします！</p>
        </div>
        <div class="p-line__footer">
            <a href="https://line.me/R/ti/p/@651htnqp?from=page" target="_blank" rel="noopener noreferrer"
                class="p-line__button">LINE追加<i class="u-icon__link"></i></a>
        </div>
        </div>
    </div>
    </div>
</div>
<!-- /.p-line -->

<footer class="l-footer p-footer">
    <div class="p-fixedLine">
        <a href="https://line.me/R/ti/p/@651htnqp?from=page" target="_blank" rel="noopener noreferrer"
        class="p-fixedLine__link">
        <i class="u-icon__line"></i>
        <p class="p-fixedLine__link__text"><span class="u-sp-hidden">POSSE</span>公式LINEで<br>最新情報をGET！</p>
        <i class="u-icon__link"></i>
        </a>
    </div>
    <div class="l-footer__inner">
        <div class="p-footer__siteinfo">
        <span class="p-footer__logo">
            <img src="./assets/img/logo.svg" alt="POSSE">
        </span>
        <a href="https://posse-ap.com/" target="_blank" rel="noopener noreferrer"
            class="p-footer__siteinfo__link">POSSE公式サイト</a>
    </div>
    <div class="p-footer__sns">
        <ul class="p-sns__list p-footer__sns__list">
            <li class="p-sns__item">
            <a href="https://twitter.com/posse_program" target="_blank" rel="noopener noreferrer"
                class="p-sns__item__link" aria-label="Twitter">
                <i class="u-icon__twitter"></i>
            </a>
            </li>
            <li class="p-sns__item">
            <a href="https://www.instagram.com/posse_programming/" target="_blank" rel="noopener noreferrer"
                class="p-sns__item__link" aria-label="instagram">
                <i class="u-icon__instagram"></i>
            </a>
            </li>
        </ul>
    </div>
    </div>
    <div class="p-footer__copyright">
        <small lang="en">©︎2022 POSSE</small>
    </div>
</footer>
<!-- /.l-footer .p-footer -->
</body>
</html>
