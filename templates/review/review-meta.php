<?php
/**
 * The template to display the reviewers meta data (name, verified owner, review date)
 *
 * @var $show_schema
 */

defined( 'ABSPATH' ) || exit;

if (empty($comment)) return;

$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

if ( '0' === $comment->comment_approved ) { ?>
	<div class="meta">
		<em class="woocommerce-review__awaiting-approval"<?php echo $show_schema ? ' itemprop="author" itemscope itemtype="https://schema.org/Person"' : ''; ?>>
            <span<?php echo $show_schema ? ' itemprop="name"' : ''; ?>>
			    <?php esc_html_e( 'Your review is awaiting approval', 'woocommerce' ); ?>
            </span>
		</em>
	</div>

<?php } else { ?>

	<div class="meta">
		<strong class="woocommerce-review__author"<?php echo $show_schema ? ' itemprop="author" itemscope itemtype="https://schema.org/Person"' : ''; ?>>
            <span<?php echo $show_schema ? ' itemprop="name"' : ''; ?>>
                <?php comment_author(); ?>
            </span>
        </strong>
		<?php
		if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
			echo '<em class="woocommerce-review__verified verified">(' . esc_attr__( 'verified owner', 'woocommerce' ) . ')</em> ';
		}

		?>
		<span class="woocommerce-review__dash">&ndash;</span> <time class="woocommerce-review__published-date" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>"><?php echo esc_html( get_comment_date( wc_date_format() ) ); ?></time>
	</div>

<?php
}
