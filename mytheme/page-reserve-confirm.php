<?php
/**
 * Template Name: ご予約 確認画面
 *
 * 静的 HTML: reserve-confirm.html
 *
 * フォームの送信処理は未実装。
 * Contact Form 7 等のプラグイン採用可否が未決定のため、マークアップの移植のみを行う。
 * 確認内容（dd の値）は静的 HTML のダミー値のまま。入力値の受け取り・表示は未実装。
 *
 * @package Valentine_Rose
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();

$vr_img = VR_THEME_URI . '/assets/images';
$vr_doc = VR_THEME_URI . '/assets/documents';
?>

<main id="main" class="reserve-page">
    <section class="page-hero" aria-labelledby="page-hero-heading">
        <div class="page-hero__title-strip">
            <div class="inner">
                <h1 id="page-hero-heading" class="page-hero__title">Reserve</h1>
            </div>
        </div>
        <div class="page-hero__parallax js-page-hero-parallax">
            <div class="page-hero__bg">
                <picture>
                    <source media="(max-width: 768px)" srcset="<?php echo esc_url($vr_img . '/page/reserve_top-sp.jpg'); ?>">
                    <img class="page-hero__img" src="<?php echo esc_url($vr_img . '/page/reserve_top-pc.jpg'); ?>" width="1440" height="600" alt="" loading="eager" decoding="async">
                </picture>
            </div>
        </div>
    </section>

    <div class="reserve-page__breadcrumb-bar">
        <div class="inner">
            <nav class="breadcrumb" aria-label="パンくず">
                <ol class="breadcrumb__list">
                    <li class="breadcrumb__item"><a href="<?php echo esc_url(vr_url('home')); ?>">ホーム</a></li>
                    <li class="breadcrumb__item"><span aria-current="page">ご予約・お問い合わせ</span></li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="reserve-consent" aria-labelledby="reserve-consent-heading">
        <div class="inner reserve-consent__inner">
            <div class="reserve-consent__layout">
              <div class="reserve-consent__text-block">
                <h2 id="reserve-consent-heading" class="reserve-consent__title">未成年のお客様は必ず<br class="reserve-consent__title-br">お読みください</h2>
                <p class="reserve-consent__text">脱毛箇所を問わず、未成年のお客様が施術を受けるためには、<br class="u-sp-br">保護者の同意が必要です。<br>「未成年契約同意書」をダウンロードし、保護者にご記入いただいた上で初回ご来店時に持参ください。</p>
              </div>
              <div class="reserve-consent__download">
                <p class="reserve-consent__download-lead">未成年契約同意書</p>
                <a href="<?php echo esc_url($vr_doc . '/valentine-rose-minors-consent.pdf'); ?>" class="reserve-consent__download-btn" download="valentine-rose-minors-consent.pdf">
                  <i class="fa-solid fa-file-arrow-down" aria-hidden="true"></i>
                  <span>Download</span>
                </a>
              </div>
            </div>
        </div>
    </section>

    <section class="reserve-tel" aria-labelledby="reserve-tel-heading">
        <div class="inner reserve-tel__inner">
            <div class="reserve-tel__col reserve-tel__col--text">
                <h2 id="reserve-tel-heading" class="reserve-tel__label" lang="en">TEL</h2>
                <p class="reserve-tel__text">サービス・料金の質問や無料体験のご予約などを希望の方は、ご希望の店舗にお問い合わせください。<br>なお、施術中は、お電話に対応することができない可能性がありますので、あらためてお電話いただくか、メールフォームからお問い合わせください。</p>
            </div>
            <div class="reserve-tel__vline" aria-hidden="true"></div>
            <div class="reserve-tel__col reserve-tel__col--num">
                <p class="reserve-tel__number"><a href="tel:0123456789">01-2345-6789</a></p>
                <p class="reserve-tel__hours">9:00～22:00 定休日なし</p>
            </div>
        </div>
    </section>

    <section class="reserve-mail" aria-labelledby="reserve-mail-heading">
        <div class="inner reserve-mail__inner">
            <div class="reserve-mail__head">
                <div class="reserve-mail__intro">
                    <h2 id="reserve-mail-heading" class="reserve-mail__title" lang="en">Mail Form</h2>
                    <div class="reserve-mail__lead">
                        <p class="reserve-mail__lead-line">脱毛の無料体験や施術のご予約などをご希望の方は、</p>
                        <p class="reserve-mail__lead-line">以下のフォームに必要事項を入力の上でお問い合わせください。</p>
                        <p class="reserve-mail__lead-line">なお、当日または翌日のご予約を希望の方は、お電話で問い合わせください。</p>
                    </div>
                </div>
                <ol class="reserve-steps" aria-label="送信の流れ">
                    <li class="reserve-steps__item">
                        <span class="reserve-steps__en" lang="en">Step 01</span>
                        <span class="reserve-steps__ja">内容入力</span>
                    </li>
                    <li class="reserve-steps__item reserve-steps__item--current">
                        <span class="reserve-steps__en" lang="en">Step 02</span>
                        <span class="reserve-steps__ja">内容確認</span>
                    </li>
                    <li class="reserve-steps__item">
                        <span class="reserve-steps__en" lang="en">Step 03</span>
                        <span class="reserve-steps__ja">送信完了</span>
                    </li>
                </ol>
            </div>

            <?php // action は暫定値。完了画面への遷移・メール送信などの送信処理は未実装。 ?>
            <form class="reserve-form reserve-form--confirm" action="<?php echo esc_url(vr_url('reserve')); ?>" method="get">
                <p class="visually-hidden">入力内容をご確認のうえ、送信ボタンを押してください。</p>
                <dl class="reserve-confirm-list">
                  <div class="reserve-confirm-list__row">
                    <dt class="reserve-field__label reserve-confirm-list__dt">
                      <span class="reserve-badge reserve-badge--req">必須</span>
                      <span class="reserve-field__name">お名前</span>
                    </dt>
                    <dd class="reserve-confirm-list__dd">山田 太郎</dd>
                  </div>
                  <div class="reserve-confirm-list__row">
                    <dt class="reserve-field__label reserve-confirm-list__dt">
                      <span class="reserve-badge reserve-badge--req">必須</span>
                      <span class="reserve-field__name">ふりがな</span>
                    </dt>
                    <dd class="reserve-confirm-list__dd">やまだ たろう</dd>
                  </div>
                  <div class="reserve-confirm-list__row">
                    <dt class="reserve-field__label reserve-confirm-list__dt">
                      <span class="reserve-badge reserve-badge--opt">任意</span>
                      <span class="reserve-field__name">電話番号</span>
                    </dt>
                    <dd class="reserve-confirm-list__dd">000-0000-0000</dd>
                  </div>
                  <div class="reserve-confirm-list__row">
                    <dt class="reserve-field__label reserve-confirm-list__dt">
                      <span class="reserve-badge reserve-badge--req">必須</span>
                      <span class="reserve-field__name">メールアドレス</span>
                    </dt>
                    <dd class="reserve-confirm-list__dd">example@gmail.com</dd>
                  </div>
                  <div class="reserve-confirm-list__row">
                    <dt class="reserve-field__label reserve-confirm-list__dt">
                      <span class="reserve-badge reserve-badge--req">必須</span>
                      <span class="reserve-field__name">ご希望の連絡方法</span>
                    </dt>
                    <dd class="reserve-confirm-list__dd">平日の日中にお電話でご連絡ください</dd>
                  </div>
                  <div class="reserve-confirm-list__row">
                    <dt class="reserve-field__label reserve-confirm-list__dt">
                      <span class="reserve-badge reserve-badge--opt">任意</span>
                      <span class="reserve-field__name">ご希望の連絡時間帯</span>
                    </dt>
                    <dd class="reserve-confirm-list__dd">平日 10:00-13:00 / 休日 13:00-17:00</dd>
                  </div>
                  <div class="reserve-confirm-list__row">
                    <dt class="reserve-field__label reserve-confirm-list__dt">
                      <span class="reserve-badge reserve-badge--req">必須</span>
                      <span class="reserve-field__name">お問い合わせ項目</span>
                    </dt>
                    <dd class="reserve-confirm-list__dd">施術のご予約</dd>
                  </div>
                  <div class="reserve-confirm-list__row">
                    <dt class="reserve-field__label reserve-confirm-list__dt">
                      <span class="reserve-badge reserve-badge--req">必須</span>
                      <span class="reserve-field__name">希望店舗</span>
                    </dt>
                    <dd class="reserve-confirm-list__dd">VALENTINE ROSE 渋谷店</dd>
                  </div>
                  <div class="reserve-confirm-list__row">
                    <dt class="reserve-field__label reserve-confirm-list__dt">
                      <span class="reserve-badge reserve-badge--opt">任意</span>
                      <span class="reserve-field__name">来店希望日（第一希望）</span>
                    </dt>
                    <dd class="reserve-confirm-list__dd">2024/03/14</dd>
                  </div>
                  <div class="reserve-confirm-list__row">
                    <dt class="reserve-field__label reserve-confirm-list__dt">
                      <span class="reserve-badge reserve-badge--opt">任意</span>
                      <span class="reserve-field__name">来店希望日（第二希望）</span>
                    </dt>
                    <dd class="reserve-confirm-list__dd">2024/03/21</dd>
                  </div>
                  <div class="reserve-confirm-list__row">
                    <dt class="reserve-field__label reserve-confirm-list__dt">
                      <span class="reserve-badge reserve-badge--opt">任意</span>
                      <span class="reserve-field__name">お問い合わせ内容</span>
                    </dt>
                    <dd class="reserve-confirm-list__dd">テキストが入ります。テキストが入ります。</dd>
                  </div>
                </dl>

                <div class="reserve-form__actions">
                    <a href="<?php echo esc_url(vr_url('reserve')); ?>" class="reserve-form__back">修正する</a>
                    <button type="submit" class="reserve-submit button">送信</button>
                </div>
            </form>
        </div>
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
