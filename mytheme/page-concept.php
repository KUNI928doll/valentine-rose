<?php
/**
 * Template Name: Concept
 *
 * 静的 HTML: concept.html の <main> 内を移植。
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
    <!-- SALON CONCEPT（KV: 下層共通 page-hero / パララックス） -->
    <section class="salon-concept" aria-labelledby="salon-concept-heading">
      <section class="page-hero" aria-labelledby="salon-concept-heading">
        <div class="page-hero__title-strip">
          <div class="inner">
            <h1 id="salon-concept-heading" class="page-hero__title">Salon Concept</h1>
          </div>
        </div>
        <div class="page-hero__parallax js-page-hero-parallax">
          <div class="page-hero__bg">
            <picture>
              <source media="(max-width: 768px)" srcset="<?php echo esc_url($vr_img . '/page/page-concept_top-sp.jpg'); ?>">
              <img
                class="page-hero__img"
                src="<?php echo esc_url($vr_img . '/page/page-concept_top-pc.jpg'); ?>"
                width="1440"
                height="600"
                alt="施術の様子"
                loading="eager"
                decoding="async"
              >
            </picture>
          </div>
        </div>
      </section>
      <div class="concept-page__breadcrumb-bar">
        <div class="inner">
          <nav class="breadcrumb" aria-label="パンくず">
            <ol class="breadcrumb__list">
              <li class="breadcrumb__item"><a href="<?php echo esc_url(vr_url('home')); ?>">ホーム</a></li>
              <li class="breadcrumb__item"><span aria-current="page">サロンコンセプト</span></li>
            </ol>
          </nav>
        </div>
      </div>
      <div class="inner salon-concept__content">
        <div class="salon-concept__intro-row">
          <div class="salon-concept__intro-text">
            <h2 class="salon-concept__headline">洗練されたワンランク上の<br>女性を目指すために</h2>
          </div>
          <figure class="salon-concept__portrait">
            <img src="<?php echo esc_url($vr_img . '/page/page-concept_about.jpg'); ?>" width="720" height="405" alt="スタイリングイメージ" loading="lazy">
          </figure>
        </div>
        <p class="salon-concept__text">
          バレンタインローズは、東京や大阪、名古屋などの都市部をはじめ日本全国に店舗を構える脱毛サロンで、「洗練されたワンランク上の女性を目指す」というコンセプトのもとオーダーメイドの脱毛サービスを提供しています。 毎年30,000人以上のお客様にバレンタインローズの脱毛サービスをご利用いただいており、これまで年齢を問わず様々な女性の脱毛をサポートさせていただきました。しかし、私たちは、脱毛はあくまでもお客様がワンランク上の女性に近づくための一歩であり、目指すべきゴールではないと考えています。 お客様と脱毛サロンという関係だけでなく、脱毛の卒業後もお客様の隣で女性磨きをサポートすることができる存在となり、そしてバレンタインローズに通っていることを誇りに思ってもらえる、そんな脱毛サロンを目指していきます。
        </p>
      </div>
    </section>

    <!-- Instagram -->
    <section class="concept-instagram" aria-labelledby="concept-instagram-heading">
      <div class="inner">
        <header class="concept-instagram__head">
          <p class="concept-instagram__title-bg" aria-hidden="true">Instagram</p>
          <h2 id="concept-instagram-heading" class="concept-instagram__title">Instagram</h2>
        </header>
        <ul class="concept-instagram__grid">
          <li class="concept-instagram__cell concept-instagram__cell--placeholder" aria-hidden="true"></li>
          <li class="concept-instagram__cell concept-instagram__cell--placeholder" aria-hidden="true"></li>
          <li class="concept-instagram__cell concept-instagram__cell--placeholder" aria-hidden="true"></li>
          <li class="concept-instagram__cell concept-instagram__cell--placeholder" aria-hidden="true"></li>
          <li class="concept-instagram__cell concept-instagram__cell--placeholder" aria-hidden="true"></li>
          <li class="concept-instagram__cell concept-instagram__cell--placeholder" aria-hidden="true"></li>
        </ul>
        <p class="concept-instagram__btn-wrap">
          <a href="#" class="concept-instagram__btn" target="_blank" rel="noopener noreferrer">
            <i class="fab fa-instagram" aria-hidden="true"></i>
            <span>Instagram</span>
          </a>
        </p>
      </div>
    </section>

    <!-- Company Profile -->
    <section class="concept-profile" aria-labelledby="concept-profile-heading">
      <div class="inner">
        <header class="concept-profile__head">
          <p class="concept-profile__title-bg" aria-hidden="true">Profile</p>
          <h2 id="concept-profile-heading" class="concept-profile__title">Company Profile</h2>
        </header>
        <figure class="concept-profile__figure">
          <picture>
            <source media="(max-width: 768px)" srcset="<?php echo esc_url($vr_img . '/page/page-concept_profile-sp.jpg'); ?>">
            <img src="<?php echo esc_url($vr_img . '/page/page-concept_profile-pc.jpg'); ?>" width="540" height="211" alt="店内・施術スペースの様子" loading="lazy" decoding="async">
          </picture>
        </figure>
        <table class="concept-profile__table">
          <tbody>
            <tr>
              <th scope="row">運営会社</th>
              <td>株式会社VALENTINE ROSE</td>
              <th scope="row">商号</th>
              <td>VALENTINE ROSE</td>
            </tr>
            <tr>
              <th scope="row">代表者</th>
              <td>山田 花子</td>
              <th scope="row">所在地</th>
              <td>〒000-0000 東京都港区青山0-00-00</td>
            </tr>
            <tr>
              <th scope="row">電話番号</th>
              <td>000-0000-0000</td>
              <th scope="row">資本金</th>
              <td>3000万円</td>
            </tr>
            <tr>
              <th scope="row">従業員数</th>
              <td>200名</td>
              <th class="concept-profile__cell--blank" scope="row" aria-hidden="true"></th>
              <td class="concept-profile__cell--blank" aria-hidden="true"></td>
            </tr>
            <tr class="concept-profile__row--full">
              <th scope="row">業務内容</th>
              <td colspan="3">-脱毛サロン「VALENTINE ROSE」の運営</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Reserve -->
    <section class="reserve-cta" id="reserve">
      <a href="<?php echo esc_url(vr_url('reserve')); ?>" class="reserve-cta__link">
        <div class="reserve-cta__media">
          <picture>
            <source srcset="<?php echo esc_url($vr_img . '/page/reserve_top-sp.png'); ?>" media="(max-width: 768px)">
            <img src="<?php echo esc_url($vr_img . '/page/reserve_top-pc.png'); ?>" width="1024" height="284" alt="明るい受付・カウンターの様子" loading="lazy">
          </picture>
        </div>
        <span class="reserve-cta__overlay" aria-hidden="true"></span>
        <div class="reserve-cta__copy">
          <p class="reserve-cta__title">RESERVE</p>
          <p class="reserve-cta__lead">予約はこちらから</p>
        </div>
      </a>
    </section>

    <!-- Salons / SNS -->
    <section class="salons-sns" id="salons" aria-labelledby="salons-sns-heading">
      <h2 id="salons-sns-heading" class="salons-sns__heading visually-hidden">店舗・SNS</h2>
      <div class="inner">
        <div class="salons-sns__row">
          <a href="<?php echo esc_url(vr_url('salons')); ?>" class="salons-sns__col">
            <span class="salons-sns__title" lang="en">SALONS</span>
            <span class="salons-sns__sub">店舗一覧</span>
          </a>
          <span class="salons-sns__vline" aria-hidden="true"></span>
          <a href="#" class="salons-sns__col">
            <span class="salons-sns__title" lang="en">SNS</span>
            <span class="salons-sns__sub">インスタグラム</span>
          </a>
        </div>
        <div class="salons-sns__rule" aria-hidden="true"></div>
      </div>
    </section>
  </main>
<?php
get_footer();
