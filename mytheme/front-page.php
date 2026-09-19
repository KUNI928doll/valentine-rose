<?php
/**
 * Front page (TOP)
 *
 * 静的 HTML: index.html の <main> 内を移植。
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
     <main>
         <div class="fv">
           <div class="fv__inner">
             <picture>
              <source srcset="<?php echo esc_url($vr_img . '/page/fv_bg-sp.jpg'); ?>" media="(max-width: 768px)">
               <img src="<?php echo esc_url($vr_img . '/page/fv_bg-pc.jpg'); ?>" alt="メインビジュアル背景">
             </picture>
             <div class="fv__title-wrap">
               <p class="fv__title">
                <span class="fv__title-line">自分を知っている人は</span><span class="fv__title-line">美しい。</span>
               </p>
             </div>
           </div>
         </div>

    <!-- News -->
    <section class="news" id="news">
      <div class="inner">
        <div class="news__head">
          <div class="news__title-group">
            <h2 class="news__title">
              <span class="section-title__en">News</span>
              <span class="section-title__bg" aria-hidden="true">News</span>
            </h2>
            <p class="section-title__ja">お知らせ</p>
          </div>
          <a href="<?php echo esc_url(vr_url('news')); ?>" class="button md-show">View All</a>
        </div>
        <ul class="news__list">
          <?php
            $vr_news_query = new WP_Query(
                array(
                    'post_type'      => 'news',
                    'posts_per_page' => 3,
                )
            );
            if ($vr_news_query->have_posts()) :
                while ($vr_news_query->have_posts()) :
                    $vr_news_query->the_post();
                    $vr_news_label = function_exists('get_field') ? get_field('news_label') : '';
                    if (! $vr_news_label) {
                        $vr_news_label = 'Category';
                    }
                    ?>
          <li class="news__item">
            <a href="<?php the_permalink(); ?>" class="news__link">
              <time class="news__date" datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php echo esc_html(get_the_date('Y.m.d')); ?></time>
              <p class="news__text"><?php echo esc_html(get_the_title()); ?></p>
              <span class="news__category"><?php echo esc_html($vr_news_label); ?></span>
            </a>
          </li>
                    <?php
                endwhile;
            endif;
            wp_reset_postdata();
          ?>
        </ul>
        <div class="news__btn-wrap u-sp-only">
          <a href="<?php echo esc_url(vr_url('news')); ?>" class="button">View All</a>
        </div>
      </div>
    </section>

    <!-- Concept -->
    <section class="concept" id="concept">
      <div class="inner concept__inner">
        <div class="concept__head-row">
          <div class="concept__lead">
            <h2 class="concept__title">
              <span class="section-title__en">Concept</span>
              <span class="section-title__bg" aria-hidden="true">Concept</span>
            </h2>
            <p class="section-title__ja">コンセプト</p>
            <p class="concept__catch">
              <span class="concept__catch-part">洗練された</span><span class="concept__catch-part">ワンランク上の</span><span class="concept__catch-part">女性を目指す</span>
            </p>
          </div>
          <figure class="concept__side u-sp-only">
            <img src="<?php echo esc_url($vr_img . '/page/top-concept_02-sp.jpg'); ?>" width="108" height="245" alt="スタイリングイメージ" loading="lazy">
          </figure>
        </div>
        <figure class="concept__hero">
          <picture>
            <source srcset="<?php echo esc_url($vr_img . '/page/top-concept_01-sp.jpg'); ?>" media="(max-width: 768px)">
            <img src="<?php echo esc_url($vr_img . '/page/top-concept_01-pc.jpg'); ?>" width="865" height="680" alt="脱毛施術の様子" loading="lazy" decoding="async">
          </picture>
        </figure>
        <div class="concept__row-bottom">
          <figure class="concept__reception md-show">
            <img src="<?php echo esc_url($vr_img . '/page/top-concept_02-pc.jpg'); ?>" width="540" height="211" alt="店内・受付の様子" loading="lazy">
          </figure>
          <div class="concept__article">
            <p class="concept__text">
              バレンタインローズでは脱毛の完了はゴールではなく,<br>あくまでもお客様がワンランク上の女性に近づくための<br>第一歩と考えています。
              <br>「洗練されたワンランク上の女性を目指す」<br>というコンセプトのもと、<br>スタッフが徹底したホスピタリティによりお客様をもてなし、<br>脱毛を通してお客様が理想とする女性像に導きます。
            </p>
            <a href="<?php echo esc_url(vr_url('concept')); ?>" class="concept__more">
              View More
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Feature（PC: 左ナビ / 中央画像+見出し重ね / 右テキスト・5秒自動フェード） -->
    <section class="feature" id="feature">
      <div class="inner">
        <div class="feature__content js-feature-slider">
          <ul class="feature__nav" role="tablist" aria-label="特徴の切り替え">
            <li class="feature__nav-item">
              <button type="button" class="feature__nav-btn is-active" id="feature-tab-0" role="tab" aria-selected="true" aria-controls="feature-panel-0">
                <span class="feature__nav-num" aria-hidden="true">Ⅰ</span>
                <span class="feature__nav-text">高性能の機械を導入</span>
              </button>
            </li>
            <li class="feature__nav-item">
              <button type="button" class="feature__nav-btn" id="feature-tab-1" role="tab" aria-selected="false" aria-controls="feature-panel-1">
                <span class="feature__nav-num" aria-hidden="true">Ⅱ</span>
                <span class="feature__nav-text">痛みを最小限まで抑えた施術</span>
              </button>
            </li>
            <li class="feature__nav-item">
              <button type="button" class="feature__nav-btn" id="feature-tab-2" role="tab" aria-selected="false" aria-controls="feature-panel-2">
                <span class="feature__nav-num" aria-hidden="true">Ⅲ</span>
                <span class="feature__nav-text">1回の施術は<br>入店〜退店まで約30分</span>
              </button>
            </li>
          </ul>
          <div class="feature__mid">
            <div class="feature__head feature__head--overlap">
              <h2 class="feature__title">
                <span class="section-title__en">FEATURE</span>
                <span class="section-title__bg" aria-hidden="true">Feature</span>
              </h2>
            </div>
            <div class="feature__image-panels">
              <figure class="feature__panel-img is-active">
                <div class="feature__img-frame">
                  <picture>
                    <source srcset="<?php echo esc_url($vr_img . '/page/feature_02-sp.jpg'); ?>" media="(max-width: 768px)">
                    <img src="<?php echo esc_url($vr_img . '/page/feature_02-pc.jpg'); ?>" width="450" height="630" alt="カウンターでお客様をお迎えする様子" loading="lazy" decoding="async">
                  </picture>
                </div>
              </figure>
              <figure class="feature__panel-img">
                <div class="feature__img-frame">
                  <picture>
                    <source srcset="<?php echo esc_url($vr_img . '/page/feature_01-sp.jpg'); ?>" media="(max-width: 768px)">
                    <img src="<?php echo esc_url($vr_img . '/page/feature_01-pc.jpg'); ?>" width="450" height="630" alt="脱毛器による施術の様子" loading="lazy" decoding="async">
                  </picture>
                </div>
              </figure>
              <figure class="feature__panel-img">
                <div class="feature__img-frame">
                  <picture>
                    <source srcset="<?php echo esc_url($vr_img . '/page/feature_03-sp.jpg'); ?>" media="(max-width: 768px)">
                    <img src="<?php echo esc_url($vr_img . '/page/feature_03-pc.jpg'); ?>" width="450" height="630" alt="サロンでの施術イメージ" loading="lazy" decoding="async">
                  </picture>
                </div>
              </figure>
            </div>
          </div>
          <div class="feature__text-panels">
            <div id="feature-panel-0" class="feature__panel-text is-active" role="tabpanel" aria-labelledby="feature-tab-0" aria-hidden="false">
              <p class="feature__label">FEATURE Ⅰ</p>
              <span class="feature__rule" aria-hidden="true"></span>
              <h3 class="feature__heading">高性能の機械を導入</h3>
              <p class="feature__text">
                美肌に特化したフィルターを使用し<br>
                真皮層に働きかけることで<br>
                コラーゲンの生成を促進させます。<br>
                また、むくみの原因である溜まった<br>
                リンパを流すことで顔のむくみを取り、<br>
                若々しいお肌と小顔効果が期待できます。
              </p>
            </div>
            <div id="feature-panel-1" class="feature__panel-text" role="tabpanel" aria-labelledby="feature-tab-1" aria-hidden="true">
              <p class="feature__label">FEATURE Ⅱ</p>
              <span class="feature__rule" aria-hidden="true"></span>
              <h3 class="feature__heading">痛みを最小限まで抑えた施術</h3>
              <p class="feature__text">
                毛質・毛量や脱毛箇所などに<br>合わせてオーダーメイドの<br>脱毛プランを作成し、<br>当サロンで採用している脱毛器を<br>使用して施術します。
              </p>
            </div>
            <div id="feature-panel-2" class="feature__panel-text" role="tabpanel" aria-labelledby="feature-tab-2" aria-hidden="true">
              <p class="feature__label">FEATURE Ⅲ</p>
              <span class="feature__rule" aria-hidden="true"></span>
              <h3 class="feature__heading">1回の施術は 入店〜退店まで約30分</h3>
              <p class="feature__text">
                施術自体は15分程度。<br>初回はカウンセリングもあるので<br>多少お時間をいただきますが、<br>2回目以降は薄化粧で来ていただくと、<br>入店から退店まで30分弱で済みます。
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Price Menu（PC: 左見出し＋右2列×3行・右下空セル / SP: 5行・カンプの並び） -->
    <section class="price-menu" id="price">
      <div class="inner price-menu__layout">
        <div class="price-menu__head">
          <h2 class="price-menu__title">
            <span class="price-menu__title-en">PRICE MENU</span>
            <span class="section-title__bg" aria-hidden="true">Price menu</span>
          </h2>
          <p class="price-menu__title-ja">メニュー料金</p>
        </div>
        <div class="price-menu__grid">
          <a href="<?php echo esc_url(vr_url('price') . '#price-body'); ?>" class="price-menu__link price-menu__link--body">
            <span class="price-menu__label">
              <span class="price-menu__name">Body</span>
              <span class="price-menu__sub">体脱毛</span>
            </span>
            <span class="price-menu__chev" aria-hidden="true">&gt;</span>
          </a>
          <a href="<?php echo esc_url(vr_url('price') . '#price-vline'); ?>" class="price-menu__link price-menu__link--vline">
            <span class="price-menu__label">
              <span class="price-menu__name">V-line</span>
              <span class="price-menu__sub">VIO脱毛</span>
            </span>
            <span class="price-menu__chev" aria-hidden="true">&gt;</span>
          </a>
          <a href="<?php echo esc_url(vr_url('price') . '#price-custom'); ?>" class="price-menu__link price-menu__link--custom">
            <span class="price-menu__label">
              <span class="price-menu__name">Custom</span>
              <span class="price-menu__sub">オーダーメイド</span>
            </span>
            <span class="price-menu__chev" aria-hidden="true">&gt;</span>
          </a>
          <a href="<?php echo esc_url(vr_url('price') . '#price-set'); ?>" class="price-menu__link price-menu__link--set">
            <span class="price-menu__label">
              <span class="price-menu__name">Set</span>
              <span class="price-menu__sub">セット脱毛</span>
            </span>
            <span class="price-menu__chev" aria-hidden="true">&gt;</span>
          </a>
          <a href="<?php echo esc_url(vr_url('price') . '#price-all'); ?>" class="price-menu__link price-menu__link--all">
            <span class="price-menu__label">
              <span class="price-menu__name">All</span>
              <span class="price-menu__sub">全てのメニュー</span>
            </span>
            <span class="price-menu__chev" aria-hidden="true">&gt;</span>
          </a>
          <div class="price-menu__blank" aria-hidden="true"></div>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="faq" id="faq">
      <div class="inner">
        <div class="faq__head">
          <h2 class="faq__title">
            <span class="section-title__en">FAQ</span>
            <span class="section-title__bg" aria-hidden="true">FAQ</span>
          </h2>
          <p class="section-title__ja">よくあるご質問</p>
        </div>
        <div class="faq__list">
          <div class="faq__item js-faq-item">
            <button type="button" class="faq__trigger js-faq-trigger" aria-expanded="false" aria-controls="faq-panel-1" id="faq-trigger-1">
              <span class="faq__q-text">Q. 脱毛後にまた毛が生えてくることはありますか？</span>
              <span class="faq__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
            </button>
            <div class="faq__panel" id="faq-panel-1" role="region" aria-labelledby="faq-trigger-1">
              <div class="faq__panel-inner">
                <p class="faq__answer">A. 出産や生理といったホルモンバランスの変化によって、脱毛後も体毛が生えてくるケースがあります。</p>
              </div>
            </div>
          </div>
          <div class="faq__item js-faq-item">
            <button type="button" class="faq__trigger js-faq-trigger" aria-expanded="false" aria-controls="faq-panel-2" id="faq-trigger-2">
              <span class="faq__q-text">Q. 脱毛すると汗の量が増えると聞いたことがあるのですが本当ですか？</span>
              <span class="faq__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
            </button>
            <div class="faq__panel" id="faq-panel-2" role="region" aria-labelledby="faq-trigger-2">
              <div class="faq__panel-inner">
                <p class="faq__answer">A. 脱毛によって発汗量が増えるというエビデンスはありませんが、毛がなくなることによって汗が直接衣服に触れることで、汗が増えたように感じることはあるかもしれません。</p>
              </div>
            </div>
          </div>
          <div class="faq__item js-faq-item">
            <button type="button" class="faq__trigger js-faq-trigger" aria-expanded="false" aria-controls="faq-panel-3" id="faq-trigger-3">
              <span class="faq__q-text">Q. コースの勧誘やセールスなどはありますか？</span>
              <span class="faq__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
            </button>
            <div class="faq__panel" id="faq-panel-3" role="region" aria-labelledby="faq-trigger-3">
              <div class="faq__panel-inner">
                <p class="faq__answer">A. お客様の毛質や毛量、ご予算等をお伺いして最適な脱毛プランを提案しますが、最終的にはお客様が無理なく通える範囲のコースを、ご自身で決定いただきたいと考えています。特に、初めての脱毛の場合は不安になる気持ちもよくわかりますので、その場で契約せずにゆっくりと考えていただく時間も大切です。<br><br>バレンタインローズでは、無理な勧誘やしつこい営業行為は一切行いませんので、安心して無料体験にお越しください。</p>
              </div>
            </div>
          </div>
          <div class="faq__item js-faq-item">
            <button type="button" class="faq__trigger js-faq-trigger" aria-expanded="false" aria-controls="faq-panel-4" id="faq-trigger-4">
              <span class="faq__q-text">Q. 脱毛することで毛が濃くなることはありますか？</span>
              <span class="faq__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
            </button>
            <div class="faq__panel" id="faq-panel-4" role="region" aria-labelledby="faq-trigger-4">
              <div class="faq__panel-inner">
                <p class="faq__answer">A. 脱毛によって毛が濃くなることはありません。ただし、硬毛化という現象によって一時的に体毛が濃くなるケースが稀にありますが、施術を進めていくことで少しずつ体毛は薄くなっていきます。</p>
              </div>
            </div>
          </div>
          <div class="faq__item js-faq-item">
            <button type="button" class="faq__trigger js-faq-trigger" aria-expanded="false" aria-controls="faq-panel-5" id="faq-trigger-5">
              <span class="faq__q-text">Q. 脱毛箇所を剃毛することで、かえって体毛が太くなることはありますか？</span>
              <span class="faq__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
            </button>
            <div class="faq__panel" id="faq-panel-5" role="region" aria-labelledby="faq-trigger-5">
              <div class="faq__panel-inner">
                <p class="faq__answer">A. 剃毛によって体毛が太くなることはありません。剃毛すると体毛の断面が見えやすくなることによって太く見えることはありますが、施術を重ねるたびに少しずつ薄く・細くなっていきます。</p>
              </div>
            </div>
          </div>
        </div>
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
