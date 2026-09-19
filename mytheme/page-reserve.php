<?php
/**
 * Template Name: ご予約 入力画面
 *
 * 静的 HTML: reserve.html
 *
 * フォームの送信処理は未実装。
 * Contact Form 7 等のプラグイン採用可否が未決定のため、マークアップの移植のみを行う。
 * 入力欄の name 属性は静的 HTML のまま保持している（後からどのプラグインでも流用できるように）。
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

    <!-- パンくず -->
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

    <!-- 未成年の同意書 -->
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

    <!-- お電話 -->
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

    <!-- メールフォーム -->
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
                    <li class="reserve-steps__item reserve-steps__item--current">
                        <span class="reserve-steps__en" lang="en">Step 01</span>
                        <span class="reserve-steps__ja">内容入力</span>
                    </li>
                    <li class="reserve-steps__item">
                        <span class="reserve-steps__en" lang="en">Step 02</span>
                        <span class="reserve-steps__ja">内容確認</span>
                    </li>
                    <li class="reserve-steps__item">
                        <span class="reserve-steps__en" lang="en">Step 03</span>
                        <span class="reserve-steps__ja">送信完了</span>
                    </li>
                </ol>
            </div>

            <?php // action は暫定値。確認画面への遷移・メール送信などの送信処理は未実装。 ?>
            <form class="reserve-form" action="<?php echo esc_url(vr_url('reserve')); ?>" method="get" novalidate>
                <div class="reserve-form__fields">
                    <!-- お名前 -->
                    <div class="reserve-field">
                        <div class="reserve-field__label">
                            <span class="reserve-badge reserve-badge--req">必須</span>
                            <label class="reserve-field__name" for="reserve-name">お名前</label>
                        </div>
                        <div class="reserve-field__control">
                            <input class="reserve-input" type="text" id="reserve-name" name="your_name" autocomplete="name" required placeholder="例）山田 花子">
                        </div>
                    </div>
                    <!-- フリガナ -->
                    <div class="reserve-field">
                        <div class="reserve-field__label">
                            <span class="reserve-badge reserve-badge--req">必須</span>
                            <label class="reserve-field__name" for="reserve-kana">フリガナ</label>
                        </div>
                        <div class="reserve-field__control">
                            <input class="reserve-input" type="text" id="reserve-kana" name="your_kana" required placeholder="例）ヤマダ ハナコ">
                        </div>
                    </div>
                    <!-- 電話 -->
                    <div class="reserve-field">
                        <div class="reserve-field__label">
                            <span class="reserve-badge reserve-badge--req">必須</span>
                            <label class="reserve-field__name" for="reserve-tel-input">電話番号</label>
                        </div>
                        <div class="reserve-field__control">
                            <input class="reserve-input" type="tel" id="reserve-tel-input" name="your_tel" autocomplete="tel" required placeholder="例）09012345678">
                        </div>
                    </div>
                    <!-- メール -->
                    <div class="reserve-field">
                        <div class="reserve-field__label">
                            <span class="reserve-badge reserve-badge--req">必須</span>
                            <label class="reserve-field__name" for="reserve-email">メールアドレス</label>
                        </div>
                        <div class="reserve-field__control">
                            <input class="reserve-input" type="email" id="reserve-email" name="your_email" autocomplete="email" required placeholder="例）sample@example.com">
                        </div>
                    </div>

                    <!-- お問い合わせ項目 -->
                    <fieldset class="reserve-field reserve-field--fieldset">
                        <legend class="reserve-field__legend">
                            <span class="reserve-badge reserve-badge--req">必須</span>
                            <span class="reserve-field__name">お問い合わせ項目</span>
                        </legend>
                        <div class="reserve-field__control reserve-field__control--checks">
                            <label class="reserve-check"><input type="radio" name="inquiry_type" value="reservation" required> ご予約</label>
                            <label class="reserve-check"><input type="radio" name="inquiry_type" value="other"> その他</label>
                        </div>
                    </fieldset>

                    <!-- ご希望のコース -->
                    <fieldset class="reserve-field reserve-field--fieldset">
                        <legend class="reserve-field__legend">
                            <span class="reserve-badge reserve-badge--opt">任意</span>
                            <span class="reserve-field__name">ご希望のコース</span>
                        </legend>
                        <div class="reserve-field__control reserve-field__control--grid">
                            <label class="reserve-check"><input type="checkbox" name="course[]" value="full"> 全身脱毛</label>
                            <label class="reserve-check"><input type="checkbox" name="course[]" value="vio"> VIO</label>
                            <label class="reserve-check"><input type="checkbox" name="course[]" value="parts"> 部位脱毛</label>
                            <label class="reserve-check"><input type="checkbox" name="course[]" value="trial"> トライアル</label>
                            <label class="reserve-check"><input type="checkbox" name="course[]" value="counseling"> カウンセリングのみ</label>
                        </div>
                    </fieldset>

                    <!-- 店舗 -->
                    <fieldset class="reserve-field reserve-field--fieldset">
                        <legend class="reserve-field__legend">
                            <span class="reserve-badge reserve-badge--req">必須</span>
                            <span class="reserve-field__name">店舗のご選択</span>
                        </legend>
                        <div class="reserve-field__control reserve-field__control--grid">
                            <label class="reserve-check"><input type="radio" name="salon" value="shibuya" required> VALENTINE ROSE 渋谷店</label>
                            <label class="reserve-check"><input type="radio" name="salon" value="shinjuku"> VALENTINE ROSE 新宿店</label>
                            <label class="reserve-check"><input type="radio" name="salon" value="yokohama"> VALENTINE ROSE 横浜店</label>
                        </div>
                    </fieldset>

                    <!-- ご来店目的 -->
                    <fieldset class="reserve-field reserve-field--fieldset">
                        <legend class="reserve-field__legend">
                            <span class="reserve-badge reserve-badge--req">必須</span>
                            <span class="reserve-field__name">ご来店目的</span>
                        </legend>
                        <div class="reserve-field__control reserve-field__control--grid reserve-field__control--grid-sm">
                            <label class="reserve-check"><input type="radio" name="visit_purpose" value="new" required> 新規</label>
                            <label class="reserve-check"><input type="radio" name="visit_purpose" value="return"> 再来</label>
                            <label class="reserve-check"><input type="radio" name="visit_purpose" value="change"> コース変更</label>
                        </div>
                    </fieldset>

                    <!-- ご希望日 -->
                    <div class="reserve-field reserve-field--dates">
                        <div class="reserve-field__label">
                            <span class="reserve-badge reserve-badge--req">必須</span>
                            <span class="reserve-field__name">ご希望日</span>
                        </div>
                        <div class="reserve-field__control reserve-field__control--dates">
                            <div class="reserve-date">
                                <span class="reserve-date__caption">第1希望</span>
                                <div class="reserve-date__row">
                                    <input class="reserve-input reserve-input--date" type="text" name="date_first" id="reserve-date-1" placeholder="年 / 月 / 日" inputmode="numeric" autocomplete="off" required>
                                    <button class="reserve-date__cal" type="button" aria-label="第1希望の日付を選択"><i class="far fa-calendar-alt" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="reserve-date">
                                <span class="reserve-date__caption">第2希望</span>
                                <div class="reserve-date__row">
                                    <input class="reserve-input reserve-input--date" type="text" name="date_second" id="reserve-date-2" placeholder="年 / 月 / 日" inputmode="numeric" autocomplete="off">
                                    <button class="reserve-date__cal" type="button" aria-label="第2希望の日付を選択"><i class="far fa-calendar-alt" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- お問い合わせ内容 -->
                    <div class="reserve-field reserve-field--textarea">
                        <div class="reserve-field__label reserve-field__label--top">
                            <span class="reserve-badge reserve-badge--req">必須</span>
                            <label class="reserve-field__name" for="reserve-message">お問い合わせ内容</label>
                        </div>
                        <div class="reserve-field__control">
                            <textarea class="reserve-textarea" id="reserve-message" name="your_message" rows="8" required placeholder="ご質問・ご要望をご記入ください。"></textarea>
                        </div>
                    </div>
                </div>

                <div class="reserve-form__submit">
                    <button type="submit" class="reserve-submit button">確認</button>
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
