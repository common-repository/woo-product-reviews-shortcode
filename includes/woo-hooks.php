<?php
add_action('wprshrtcd_before_comments', 'wprshrtcd_output_reviews_title', 10);
add_action('wprshrtcd_before_comments', 'wprshrtcd_output_reviews_meta', 15);

add_action('wprshrtcd_comments', 'wprshrtcd_output_comments', 20);

add_action('wprshrtcd_before_comment_content', 'wprshrtcd_output_avatar', 15, 2);

add_action('wprshrtcd_comment_content', 'wprshrtcd_output_review_title', 5, 2);
add_action('wprshrtcd_comment_content', 'wprshrtcd_output_review_rating', 10, 2);
add_action('wprshrtcd_comment_content', 'wprshrtcd_output_review_meta', 15, 2);
add_action('wprshrtcd_comment_content', 'wprshrtcd_output_review_content', 20, 2);
// add_action('wprshrtcd_after_comment_content', 'wprshrtcd_');