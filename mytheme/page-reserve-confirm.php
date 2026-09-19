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
                    <source media="(max-width: 768px)" srcset="<?php echo esc_url($vr_img . '/page/reserve-link-sp.jpg'); ?>">
                    <img class="page-hero__img" src="<?php echo esc_url($vr_img . '/page/reserve-link-pc.jpg'); ?>" width="1440" height="900" alt="" loading="eager" decoding="async">
                </picture>
            </div>
        </div>
    </section>

    <div class="reserve-page__breadcrumb-bar">
        <div class="inner">
            <nav class="breadcrumb" aria-label="パンくず">
                <ol class="breadcrumb__list">
                    <li class="breadcrumb__item"><a href="<?php echo esc_url(vr_url('home')); ?>">ホーム</a></li>
                    <li class="breadcrumb__item"><span aria-current="page">ご予約（お問い合わせ）</span></li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="reserve-consent" aria-labelledby="reserve-consent-heading">
        <div class="inner reserve-consent__inner">
            <h2 id="reserve-consent-heading" class="reserve-consent__title">未成年のお客様は必ずお読みください</h2>
            <div class="reserve-consent__layout">
                <div class="reserve-consent__text-block">
                    <p class="reserve-consent__text">18歳未満の方がご来店される場合は、必ず保護者の方の同意が必要です。同意書をダウンロードのうえ、署名・捺印の上、当日ご持参ください。ご不明な点はお電話にてお問い合わせください。</p>
                </div>
                <div class="reserve-consent__download">
                    <p class="reserve-consent__download-lead">同意書のダウンロード</p>
                    <a href="<?php echo esc_url($vr_doc . '/valentine-rose-minors-consent.pdf'); ?>" class="reserve-consent__download-btn button" download="valentine-rose-minors-consent.pdf">Download</a>
                </div>
            </div>
        </div>
    </section>

    <section class="reserve-tel" aria-labelledby="reserve-tel-heading">
        <div class="inner reserve-tel__inner">
            <div class="reserve-tel__col reserve-tel__col--text">
                <h2 id="reserve-tel-heading" class="reserve-tel__lead-title">お電話でのご予約は必ずご確認ください</h2>
                <p class="reserve-tel__text">ご予約・ご相談は下記番号までお電話ください。混雑時はつながりにくい場合がございます。受付時間外はメールフォームをご利用ください。</p>
                <p class="reserve-tel__note">※キャンセル・変更もお電話にて承ります。</p>
            </div>
            <div class="reserve-tel__vline" aria-hidden="true"></div>
            <div class="reserve-tel__col reserve-tel__col--num">
                <p class="reserve-tel__label" lang="en">TEL</p>
                <p class="reserve-tel__number"><a href="tel:+81312345678">03-1234-5678</a></p>
                <p class="reserve-tel__hours">（受付時間 10:00〜19:00）</p>
                <a href="<?php echo esc_url(vr_url('salons')); ?>" class="reserve-tel__sub-link">サロン情報・アクセスはこちら</a>
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
                            <span class="reserve-field__name">フリガナ</span>
                        </dt>
                        <dd class="reserve-confirm-list__dd">ヤマダ タロウ</dd>
                    </div>
                    <div class="reserve-confirm-list__row">
                        <dt class="reserve-field__label reserve-confirm-list__dt">
                            <span class="reserve-badge reserve-badge--req">必須</span>
                            <span class="reserve-field__name">電話番号</span>
                        </dt>
                        <dd class="reserve-confirm-list__dd">080-0000-0000</dd>
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
                            <span class="reserve-field__name">お問い合わせ項目</span>
                        </dt>
                        <dd class="reserve-confirm-list__dd">ご予約</dd>
                    </div>
                    <div class="reserve-confirm-list__row">
                        <dt class="reserve-field__label reserve-confirm-list__dt">
                            <span class="reserve-badge reserve-badge--opt">任意</span>
                            <span class="reserve-field__name">ご希望のコース</span>
                        </dt>
                        <dd class="reserve-confirm-list__dd">全身脱毛、VIO</dd>
                    </div>
                    <div class="reserve-confirm-list__row">
                        <dt class="reserve-field__label reserve-confirm-list__dt">
                            <span class="reserve-badge reserve-badge--req">必須</span>
                            <span class="reserve-field__name">店舗のご選択</span>
                        </dt>
                        <dd class="reserve-confirm-list__dd">VALENTINE ROSE 渋谷店</dd>
                    </div>
                    <div class="reserve-confirm-list__row">
                        <dt class="reserve-field__label reserve-confirm-list__dt">
                            <span class="reserve-badge reserve-badge--req">必須</span>
                            <span class="reserve-field__name">ご来店目的</span>
                        </dt>
                        <dd class="reserve-confirm-list__dd">新規</dd>
                    </div>
                    <div class="reserve-confirm-list__row">
                        <dt class="reserve-field__label reserve-confirm-list__dt">
                            <span class="reserve-badge reserve-badge--req">必須</span>
                            <span class="reserve-field__name">第1希望日</span>
                        </dt>
                        <dd class="reserve-confirm-list__dd">2026/04/20</dd>
                    </div>
                    <div class="reserve-confirm-list__row">
                        <dt class="reserve-field__label reserve-confirm-list__dt">
                            <span class="reserve-badge reserve-badge--opt">任意</span>
                            <span class="reserve-field__name">第2希望日</span>
                        </dt>
                        <dd class="reserve-confirm-list__dd">2026/04/21</dd>
                    </div>
                    <div class="reserve-confirm-list__row">
                        <dt class="reserve-field__label reserve-confirm-list__dt reserve-field__label--top">
                            <span class="reserve-badge reserve-badge--req">必須</span>
                            <span class="reserve-field__name">お問い合わせ内容</span>
                        </dt>
                        <dd class="reserve-confirm-list__dd">脱毛のご予約についてお伺いしたく、メールにてお問い合わせいたしました。ご都合の良い日時をご連絡いただけますと幸いです。なお、初回のためカウンセリングもあわせて希望しております。</dd>
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
