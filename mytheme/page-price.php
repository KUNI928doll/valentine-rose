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
      <div class="inner price-page-intro__layout">
        <h2 id="price-intro-heading" class="visually-hidden">料金メニューについて</h2>
        <p class="price-page-intro__copy">バレンタインローズは、お客様のなりたい姿に合わせて選択いただけるよう「トライアルコース」「減毛コース」「脱毛コース」の3種類のコースをご用意しています。<br>トライアルコースは脱毛効果を実感したい方に、減毛コースは体毛を薄くしたい・減らしたい方に、脱毛コースは施術箇所の体毛をすべて脱毛したい方におすすめのコースです。</p>
        <ul class="price-nav">
          <li class="price-nav__item">
            <a href="#price-body" class="price-nav__link">
              <span class="price-nav__label"><span class="price-nav__name">Body</span><span class="price-nav__sub">体脱毛</span></span>
              <span class="price-nav__chev" aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
            </a>
          </li>
          <li class="price-nav__item">
            <a href="#price-vline" class="price-nav__link">
              <span class="price-nav__label"><span class="price-nav__name">V-line</span><span class="price-nav__sub">VIO脱毛</span></span>
              <span class="price-nav__chev" aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
            </a>
          </li>
          <li class="price-nav__item">
            <a href="#price-set" class="price-nav__link">
              <span class="price-nav__label"><span class="price-nav__name">Set</span><span class="price-nav__sub">セット脱毛</span></span>
              <span class="price-nav__chev" aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
            </a>
          </li>
          <li class="price-nav__item">
            <a href="#price-custom" class="price-nav__link">
              <span class="price-nav__label"><span class="price-nav__name">Custom</span><span class="price-nav__sub">オーダーメイド</span></span>
              <span class="price-nav__chev" aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
            </a>
          </li>
          <li class="price-nav__item">
            <a href="#price-all" class="price-nav__link">
              <span class="price-nav__label"><span class="price-nav__name">All</span><span class="price-nav__sub">全てのメニュー</span></span>
              <span class="price-nav__chev" aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
            </a>
          </li>
        </ul>
      </div>
    </section>

    <div class="price-list" id="price-all">
      <!-- Body -->
      <section class="price-section" id="price-body">
        <div class="inner">
          <h2 class="price-section__title">Body</h2>
          <div class="price-section__block">
            <h3 class="price-section__size">Sパーツ</h3>
            <p class="price-section__parts">おでこ・ほほ・口周り・あご下の首・うなじ・両脇・手の指&amp;甲・<br>足の指&amp;甲・へそ周り・乳輪周り</p>
            <table class="price-table">
              <caption class="visually-hidden">Sパーツの料金</caption>
              <thead>
                <tr>
                  <th scope="col"><span class="visually-hidden">区分</span></th>
                  <th scope="col">トライアルコース(3回)</th>
                  <th scope="col">減毛コース(6回)</th>
                  <th scope="col">脱毛コース(12回)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1箇所</th>
                  <td data-label="トライアルコース(3回)">7,600 円</td>
                  <td data-label="減毛コース(6回)">6,500 円</td>
                  <td data-label="脱毛コース(12回)">4,900 円</td>
                </tr>
              </tbody>
            </table>
            <p class="price-table__note">※ 表の料金は、すべて税込表記で、<br class="price-table__note-br">施術一回あたりの金額です。</p>
          </div>
          <div class="price-section__block">
            <h3 class="price-section__size">Mパーツ</h3>
            <p class="price-section__parts">お腹全体・胸全体（乳輪周りを含む）・お尻・両腕上（肘含む）・<br>両腕下・V（ハイジニーナ）</p>
            <table class="price-table">
              <caption class="visually-hidden">Mパーツの料金</caption>
              <thead>
                <tr>
                  <th scope="col"><span class="visually-hidden">区分</span></th>
                  <th scope="col">トライアルコース(3回)</th>
                  <th scope="col">減毛コース(6回)</th>
                  <th scope="col">脱毛コース(12回)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1箇所</th>
                  <td data-label="トライアルコース(3回)">14,900 円</td>
                  <td data-label="減毛コース(6回)">13,200 円</td>
                  <td data-label="脱毛コース(12回)">9,900 円</td>
                </tr>
              </tbody>
            </table>
            <p class="price-table__note">※ 表の料金は、すべて税込表記で、<br class="price-table__note-br">施術一回あたりの金額です。</p>
          </div>
          <div class="price-section__block">
            <h3 class="price-section__size">Lパーツ</h3>
            <p class="price-section__parts">背中全体・両膝上（膝含む）・両膝下</p>
            <table class="price-table">
              <caption class="visually-hidden">Lパーツの料金</caption>
              <thead>
                <tr>
                  <th scope="col"><span class="visually-hidden">区分</span></th>
                  <th scope="col">トライアルコース(3回)</th>
                  <th scope="col">減毛コース(6回)</th>
                  <th scope="col">脱毛コース(12回)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1箇所</th>
                  <td data-label="トライアルコース(3回)">22,800 円</td>
                  <td data-label="減毛コース(6回)">19,800 円</td>
                  <td data-label="脱毛コース(12回)">16,500 円</td>
                </tr>
              </tbody>
            </table>
            <p class="price-table__note">※ 表の料金は、すべて税込表記で、<br class="price-table__note-br">施術一回あたりの金額です。</p>
          </div>
        </div>
      </section>

      <!-- V-line -->
      <section class="price-section" id="price-vline">
        <div class="inner">
          <h2 class="price-section__title">V-line</h2>
          <div class="price-section__block">
            <table class="price-table">
              <caption class="visually-hidden">V-lineの料金</caption>
              <thead>
                <tr>
                  <th scope="col"><span class="visually-hidden">区分</span></th>
                  <th scope="col">トライアルコース(3回)</th>
                  <th scope="col">減毛コース(6回)</th>
                  <th scope="col">脱毛コース(12回)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1箇所</th>
                  <td data-label="トライアルコース(3回)">7,600 円</td>
                  <td data-label="減毛コース(6回)">6,500 円</td>
                  <td data-label="脱毛コース(12回)">4,900 円</td>
                </tr>
                <tr>
                  <th scope="row">2箇所</th>
                  <td data-label="トライアルコース(3回)">14,900 円</td>
                  <td data-label="減毛コース(6回)">13,200 円</td>
                  <td data-label="脱毛コース(12回)">9,900 円</td>
                </tr>
                <tr>
                  <th scope="row">3箇所</th>
                  <td data-label="トライアルコース(3回)">22,800 円</td>
                  <td data-label="減毛コース(6回)">19,800 円</td>
                  <td data-label="脱毛コース(12回)">16,500 円</td>
                </tr>
              </tbody>
            </table>
            <p class="price-table__note">※ 表の料金は、すべて税込表記で、<br class="price-table__note-br">施術一回あたりの金額です。</p>
          </div>
        </div>
      </section>

      <!-- Set -->
      <section class="price-section" id="price-set">
        <div class="inner">
          <h2 class="price-section__title">Set</h2>
          <div class="price-section__block">
            <table class="price-table">
              <caption class="visually-hidden">Setの料金</caption>
              <thead>
                <tr>
                  <th scope="col"><span class="visually-hidden">区分</span></th>
                  <th scope="col">トライアルコース(3回)</th>
                  <th scope="col">減毛コース(6回)</th>
                  <th scope="col">脱毛コース(12回)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">顔全体</th>
                  <td data-label="トライアルコース(3回)">7,600 円</td>
                  <td data-label="減毛コース(6回)">6,500 円</td>
                  <td data-label="脱毛コース(12回)">4,900 円</td>
                </tr>
                <tr>
                  <th scope="row">腕全体</th>
                  <td data-label="トライアルコース(3回)">14,900 円</td>
                  <td data-label="減毛コース(6回)">13,200 円</td>
                  <td data-label="脱毛コース(12回)">9,900 円</td>
                </tr>
                <tr>
                  <th scope="row">足全体</th>
                  <td data-label="トライアルコース(3回)">22,800 円</td>
                  <td data-label="減毛コース(6回)">19,800 円</td>
                  <td data-label="脱毛コース(12回)">16,500 円</td>
                </tr>
                <tr>
                  <th scope="row">全身脱毛</th>
                  <td data-label="トライアルコース(3回)">27,200 円</td>
                  <td data-label="減毛コース(6回)">24,800 円</td>
                  <td data-label="脱毛コース(12回)">20,900 円</td>
                </tr>
              </tbody>
            </table>
            <p class="price-table__note">※ 表の料金は、すべて税込表記で、<br class="price-table__note-br">施術一回あたりの金額です。</p>
          </div>
        </div>
      </section>
    </div>

    <!-- Custom -->
    <section class="price-custom" id="price-custom" aria-labelledby="price-custom-heading">
      <div class="price-custom__layout">
        <figure class="price-custom__figure">
          <img src="<?php echo esc_url($vr_img . '/page/price-menu_custom.jpg'); ?>" width="480" height="480" alt="オーダーメイド脱毛のイメージ" loading="lazy" decoding="async">
        </figure>
        <div class="price-custom__body">
          <h2 id="price-custom-heading" class="price-custom__title">Custom</h2>
          <p class="price-custom__text">施術の効果は、脱毛箇所や毛質・毛量、毛周期などによって大きく左右されるため、画一的な施術ではお客様に合わせた最適な脱毛サービスを提供することはできません。</p>
          <p class="price-custom__text">バレンタインローズでは、お客様に施術の効果をしっかりと感じていただくことができるよう、カウンセリング内容や脱毛箇所、毛質・毛量などを考慮し、オーダーメイドの脱毛メニューを作成しています。</p>
          <p class="price-custom__text">よりお求めやすい価格で脱毛サービスを提供することができるケースもございますので、オーダーメイドの脱毛メニューをご希望の方はお気軽にご相談ください。</p>
        </div>
      </div>
    </section>

    <section class="reserve-cta" id="reserve">
      <a href="<?php echo esc_url(vr_url('reserve')); ?>" class="reserve-cta__link">
        <div class="reserve-cta__media">
          <picture>
            <source srcset="<?php echo esc_url($vr_img . '/page/reserve_top-sp.png'); ?>" width="375" height="200" media="(max-width: 768px)">
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
