<?php
/*
Plugin Name: ohinery
Description: Let's make ohinery (giving bitzeny) to wordpress blog more easier!
Version: 0.05_mod1
Author: raspi0124,kazu0617
Author URI: https://raspi-diary.com/
License: GPLv3
*/
/*  Copyright 2017 raspi0124 (email : admin@raspi-diary.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
Copyright  2017  raspi0124
このプログラムはフリーソフトウェアです。あなたはこれを、フリーソフトウェ
ア財団によって発行された GNU 一般公衆利用許諾契約書(バージョン2か、希
望によってはそれ以降のバージョンのうちどれか)の定める条件の下で再頒布
または改変することができます。
このプログラムは有用であることを願って頒布されますが、*全くの無保証* 
です。商業可能性の保証や特定の目的への適合性は、言外に示されたものも含
め全く存在しません。詳しくはGNU 一般公衆利用許諾契約書をご覧ください。
 
あなたはこのプログラムと共に、GNU 一般公衆利用許諾契約書の複製物を一部
受け取ったはずです。もし受け取っていなければ、フリーソフトウェア財団ま
で請求してください(宛先は the Free Software Foundation, Inc., 59
Temple Place, Suite 330, Boston, MA 02111-1307 USA)。
    This software includes the work that is distributed in the Apache License 2.0
*/
function ohinery_post_twitterid() {
    return get_option( 'ohinery_twitter_account' );
}

function ohinery_img_lacation( $cointype ) {
    return plugins_url( 'ohinery_' + $cointype + '.png' , __FILE__ );
}

add_shortcode('ohinery_twid', 'ohinery_post_twitterid');
add_shortcode('ohinery_imgloc', 'ohinery_img_lacation');
//add option for wordpress
    function ohinery_addfield() {
    add_settings_field( 'twitter', 'おひねりを投げる先のTwitterのIDをお願いします。', 'ohinery_twitter_field', 'general', 'default', array( 'label_for' => 'ohinery_twitter_account' ) );
}
add_action( 'admin_init', 'ohinery_addfield' );
 
function ohinery_twitter_field( $args ) {
    $ohinery_twitter_account = get_option( 'ohinery_twitter_account' );
?>
    @<input type="text" name="ohinery_twitter_account" id="ohinery_twitter_account" size="30" value="<?php echo esc_html( $ohinery_twitter_account ); ?>" />
<?php
}
function ohinery_post_amount() {
    return get_option( 'ohinery_amount' );
}
add_shortcode('ohinery_amount', 'ohinery_post_amount');
function ohinery_add_option() {
    register_setting( 'general', 'ohinery_twitter_account' );
}
add_filter( 'admin_init', 'ohinery_add_option' );
//add after post
function ohinery_addafterpost($ohinery_content) {
 
$ohinery_bottom = <<< sentence
<div class="sharedaddy sd-sharing-enabled"><h3 class="sd-title"><em>暗号通貨を投げる:</em></h3></div>
<a href="https://twitter.com/share?text=@zenyhime%20tip%20@[ohinery_twid]%200.114114%20ZNYを送ります">
<img src="[ohinery_imgloc(zeny)]" alt="おひねりをBitZenyで投げる" rel="nofollow" class="ohinery_image"></a>
<a href="https://twitter.com/share?text=@tipnem%20tip%20@[ohinery_twid]%200.114114%20NEMを送ります">
<img src="[ohinery_imgloc_nem]" alt="おひねりをNEMで投げる" rel="nofollow" class="ohinery_image"></a>
<a href="https://twitter.com/share?text=@cointip_jp%20tip%20@[ohinery_twid]%200.114114%20BTCを送ります">
<img src="[ohinery_imgloc_btc]" alt="おひねりをBTCで投げる" rel="nofollow" class="ohinery_image"></a>
<br><div class="sharedaddy sd-sharing-enabled"><h3 class="sd-title"><em>それぞれの投げ銭システムについて:</em></h3></div>
<a href="http://zenyhime.sigruru.com/" target="_blank">BitZeny(ぜにぃ姫)</a><br>
<a href="http://bitzeny.org/" target="_blank">そもそもBitZenyってなに？</a></center><style>
.ohinery_image {
    max-width: 100px;  /* 横幅を300pxに */
}
</style>
sentence;
 
    if(!is_feed() && !is_home()) {
        $ohinery_content .= $ohinery_bottom;
    }
    return $ohinery_content;
}
add_filter('the_content', 'ohinery_addafterpost');
