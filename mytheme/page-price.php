<?php
/**
 * Template Name: Price
 *
 * 静的 HTML: price.html の <main> 内を移植。
 * ヘッダー / ドロワー / フッターは header.php / footer.php が持つ。
 *
 * @package Valentine_Rose
 */

if (! defined('ABSPATH')) {
    exit;
}

$vr_img = VR_THEME_URI . '/assets/images';

get_header();
?>
  <main id="main">
    <section class="page-hero" aria-labelledby="page-hero-heading">
      <div class="page-hero__title-strip">
        <div class="inner">
          <h1 id="page-hero-heading" class="page-hero__title">Price Menu</h1>
        </div>
      </div>
      <div class="page-hero__parallax js-page-hero-parallax">
        <div class="page-hero__bg">
          <picture>
            <source media="(max-width: 768px)" srcset="<?php echo esc_url($vr_img . '/page/price-menu_top-sp.jpg'); ?>">
            <img class="page-hero__img" src="<?php echo esc_url($vr_img . '/page/price-menu_top-pc.jpg'); ?>" width="1440" height="600" alt="" loading="eager" decoding="async">
          </picture>
        </div>
      </div>
    </section>

    <!-- 導入 + アンカー -->
    <section class="price-page-intro" aria-labelledby="price-intro-heading">
      <div class="price-page-intro__breadcrumb-bar">
        <div class="inner">
          <nav class="breadcrumb" aria-label="パンくず">
            <ol class="breadcrumb__list">
              <li class="breadcrumb__item"><a href="<?php echo esc_url(vr_url('home')); ?>">ホーム</a></li>
              <li class="breadcrumb__item"><span aria-current="page">メニュー料金</span></li>
            </ol>
          </nav>
        </div>
      </div>
      <div class="price-page-intro__main">
      <div class="inner price-page-intro__layout">
        <div>
          <h2 id="price-intro-heading" class="visually-hidden">料金メニューについて</h2>
          <p class="price-page-intro__copy">
            バレンタインローズは、お客様のなりたい姿に合わせて選択いただけるよう「トライアルコース」「減毛コース」「脱毛コース」の3種類のコースをご用意しています。 トライアルコースは脱毛効果を実感したい方に、減毛コースは体毛を薄くしたい・減らしたい方に、脱毛コースは施術箇所の体毛をすべて脱毛したい方におすすめのコースです。
          </p>
        </div>
        <div class="price-page-intro__nav">
          <div class="price-menu__grid">
            <a href="#price-body" class="price-menu__link price-menu__link--body">
              <span class="price-menu__label">
                <span class="price-menu__name">Body</span>
                <span class="price-menu__sub">体脱毛</span>
              </span>
              <span class="price-menu__chev" aria-hidden="true">&gt;</span>
            </a>
            <a href="#price-vline" class="price-menu__link price-menu__link--vline">
              <span class="price-menu__label">
                <span class="price-menu__name">V-line</span>
                <span class="price-menu__sub">VIO脱毛</span>
              </span>
              <span class="price-menu__chev" aria-hidden="true">&gt;</span>
            </a>
            <a href="#price-custom" class="price-menu__link price-menu__link--custom">
              <span class="price-menu__label">
                <span class="price-menu__name">Custom</span>
                <span class="price-menu__sub">オーダーメイド</span>
              </span>
              <span class="price-menu__chev" aria-hidden="true">&gt;</span>
            </a>
            <a href="#price-set" class="price-menu__link price-menu__link--set">
              <span class="price-menu__label">
                <span class="price-menu__name">Set</span>
                <span class="price-menu__sub">セット脱毛</span>
              </span>
              <span class="price-menu__chev" aria-hidden="true">&gt;</span>
            </a>
            <a href="#price-all" class="price-menu__link price-menu__link--all">
              <span class="price-menu__label">
                <span class="price-menu__name">All</span>
                <span class="price-menu__sub">全てのメニュー</span>
              </span>
              <span class="price-menu__chev" aria-hidden="true">&gt;</span>
            </a>
            <div class="price-menu__blank" aria-hidden="true"></div>
          </div>
        </div>
      </div>
      </div>
    </section>

    <!-- Body -->
    <section class="price-section" id="price-body">
      <div class="price-section__inner">
        <h2 class="price-section__title">Body</h2>
        <p class="price-section__title-ja">体脱毛</p>

        <div class="price-section__block">
          <h3 class="price-section__category">Back</h3>
          <div class="price-table-wrap">
            <table class="price-table">
              <caption class="visually-hidden">背中エリアの料金</caption>
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col">1回</th>
                  <th scope="col">6回</th>
                  <th scope="col">12回</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">全背中</th>
                  <td>7,000円</td>
                  <td>39,000円</td>
                  <td>72,000円</td>
                </tr>
                <tr>
                  <th scope="row">上背中</th>
                  <td>5,000円</td>
                  <td>28,000円</td>
                  <td>52,000円</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="price-section__block">
          <h3 class="price-section__category">Bottom</h3>
          <div class="price-table-wrap">
            <table class="price-table">
              <caption class="visually-hidden">下半身エリアの料金</caption>
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col">1回</th>
                  <th scope="col">6回</th>
                  <th scope="col">12回</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">ヒップ（Oライン）</th>
                  <td>6,000円</td>
                  <td>33,000円</td>
                  <td>62,000円</td>
                </tr>
                <tr>
                  <th scope="row">太もも 全面</th>
                  <td>8,500円</td>
                  <td>47,000円</td>
                  <td>88,000円</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>

    <!-- V-line -->
    <section class="price-section price-section--alt" id="price-vline">
      <div class="price-section__inner">
        <h2 class="price-section__title">V-line</h2>
        <p class="price-section__title-ja">VIO脱毛</p>

        <div class="price-section__block">
          <h3 class="price-section__category">VIO</h3>
          <div class="price-table-wrap">
            <table class="price-table">
              <caption class="visually-hidden">VIOの料金</caption>
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col">1回</th>
                  <th scope="col">6回</th>
                  <th scope="col">12回</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">VIOセット</th>
                  <td>12,000円</td>
                  <td>66,000円</td>
                  <td>120,000円</td>
                </tr>
                <tr>
                  <th scope="row">Vライン</th>
                  <td>6,500円</td>
                  <td>36,000円</td>
                  <td>67,000円</td>
                </tr>
                <tr>
                  <th scope="row">Iライン・Oライン</th>
                  <td>各5,500円</td>
                  <td>各30,000円</td>
                  <td>各56,000円</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>

    <!-- Set -->
    <section class="price-section" id="price-set">
      <div class="price-section__inner">
        <h2 class="price-section__title">Set</h2>
        <p class="price-section__title-ja">セット脱毛</p>

        <div class="price-section__block">
          <div class="price-table-wrap">
            <table class="price-table">
              <caption class="visually-hidden">セットコースの料金</caption>
              <thead>
                <tr>
                  <th scope="col">コース名</th>
                  <th scope="col">1回</th>
                  <th scope="col">6回</th>
                  <th scope="col">12回</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">全身＋VIO</th>
                  <td>22,000円</td>
                  <td>118,000円</td>
                  <td>220,000円</td>
                </tr>
                <tr>
                  <th scope="row">全身（VIO除く）</th>
                  <td>18,000円</td>
                  <td>98,000円</td>
                  <td>182,000円</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>

    <!-- Custom -->
    <section class="price-custom" id="price-custom">
      <div class="price-custom__inner">
        <div class="price-custom__layout">
          <figure class="price-custom__figure">
            <img src="<?php echo esc_url($vr_img . '/page/price-menu_custom.jpg'); ?>" width="540" height="540" alt="オーダーメイド脱毛のイメージ" loading="lazy" decoding="async">
          </figure>
          <div class="price-custom__body">
            <h2 class="price-custom__title">Custom</h2>
            <p class="price-custom__text">
              お客様の毛質・肌質・ライフスタイルに合わせたオーダーメイドプランをご提案します。脱毛範囲や回数の組み合わせはカウンセリングにてご相談ください。料金はお選びいただくメニューに応じてお見積りいたします。
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- 注記・全メニュー -->
    <section class="price-page-note" id="price-all">
      <div class="price-page-note__inner">
        <p class="price-page-note__text">
          ※表示価格はすべて税込です。※回数券の有効期限はご購入日より1年間です。※メニュー内容・価格は予告なく変更する場合がございます。最新情報は各店舗へお問い合わせください。
        </p>
      </div>
    </section>

    <section class="reserve-cta" id="reserve">
      <a href="<?php echo esc_url(vr_url('reserve')); ?>" class="reserve-cta__link">
        <div class="reserve-cta__media">
          <picture>
            <source srcset="<?php echo esc_url($vr_img . '/page/reserve_top-sp.png'); ?>" media="(max-width: 768px)">
            <img src="<?php echo esc_url($vr_img . '/page/reserve_top-pc.png'); ?>" width="1024" height="284" alt="" loading="lazy">
          </picture>
        </div>
        <span class="reserve-cta__overlay" aria-hidden="true"></span>
        <div class="reserve-cta__copy"><p class="reserve-cta__title">RESERVE</p><p class="reserve-cta__lead">予約はこちらから</p></div>
      </a>
    </section>
    <section class="salons-sns" id="salons" aria-labelledby="salons-sns-heading">
      <h2 id="salons-sns-heading" class="salons-sns__heading visually-hidden">店舗・SNS</h2>
      <div class="inner">
        <div class="salons-sns__row">
          <a href="<?php echo esc_url(vr_url('salons')); ?>" class="salons-sns__col"><span class="salons-sns__title" lang="en">SALONS</span><span class="salons-sns__sub">店舗一覧</span></a>
          <span class="salons-sns__vline" aria-hidden="true"></span>
          <a href="#" class="salons-sns__col"><span class="salons-sns__title" lang="en">SNS</span><span class="salons-sns__sub">インスタグラム</span></a>
        </div>
        <div class="salons-sns__rule" aria-hidden="true"></div>
      </div>
    </section>
  </main>
<?php
get_footer();
