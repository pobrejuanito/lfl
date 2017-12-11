<style>
    
    
  div#system-message-container
  {
    display:none;
    visibility:hidden;
  }
    
  #page-background
  {
  background:url(/images/register/banner-welcome-top.png) no-repeat;
  background-position:center top;
  }

  .mod-line p
  {
  line-height:12px !important;
  }

  .fl_login input
  {
  width: 90px !important;
  height: 21px;
  border-style: none;
  background: url(/templates/yoo_nano/styles/newsostv/images/userpass-form.png) no-repeat;
  }

  .fl_login input
  {
  margin-top:5px;
  }

  .fl_login div
  {
  margin: 5px 0 !important;
  }

  .fl_login
  {
  float:left;
  margin:5px 0 !important;
  }

  .submit_button
  {

  }

  form.submission
  {
  margin: 124px 0 0 57px;
  }

  #system-message-container
  {
  float:left;
  }
</style>

  <?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die;

?>
<div id="system" style="padding:10px 0;">
	
	<?php if ($this->params->get('show_page_heading')) : ?>
	<h1 class="title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	<?php endif; ?>

  <div style="width:1000px; height:345px; position:relative; margin:0 auto;">
    <a style="display:block; position:absolute; top:251px; left:0px;" href="/index.php"><img src="/images/register/button-to-home.png" borde="0"></img>
    </a>
  </div>


  <section id="bottom-b" style="margin-top:35px;">
    <div class="grid-block">
      <div class="grid-box width24 grid-h" style="width: 225px; ">
        <div class="module mod-line  deepest" style="min-height: 90px; ">


          <p>
            <a href="http://www.kingsm.net/" target="_blank">
              <strong>
                <img style="margin-right: 10px; float: left;" alt="icon-naver-cafe" src="/images/main/icon-naver-cafe.png" width="87" height="83">
                  <span style="color: #000000;">네이버 카페</span>
                </strong>
            </a>
          </p>
          <p style="text-align: justify;">
            <a href="http://www.kingsm.net/" target="_blank">성경질문과 신앙상담 그리고 따뜻한 나눔이 있는 온라인 커뮤니티</a>
          </p>

        </div>
      </div>
      <div class="grid-box width24 grid-h" style="width: 225px; ">
        <div class="module mod-line  deepest" style="min-height: 90px; ">


          <p>
            <a href="/bible-cafe-info.html">
              <img style="margin-right: 10px; float: left;" src="/images/main/icon-bible-cafe.png" alt="icon-bible-cafe" width="87" height="85">
                <span style="color: #000000;">
                  <strong>바이블 카페</strong>
                </span>
              </a>
          </p>
          <p style="text-align: left;">
            <a href="/bible-cafe-info.html">언제든지 자유롭게 방문하여 편안한 교제와 성경공부를 할 수 있는 오프라인 공간!</a>
          </p>

        </div>
      </div>
      <div class="grid-box width24 grid-h" style="width: 225px; ">
        <div class="module mod-line  deepest" style="min-height: 90px; ">


          <p>
            <a href="/bible-study.html" target="_self">
              <img style="margin-right: 10px; float: left;" alt="icon-biblestudy" src="/images/main/icon-biblestudy.png" width="87" height="83">
                <span style="font-size: 8pt;">
                  <strong>
                    <span style="color: #000000;" color="#000000">성경 연구 자료</span>
                  </strong>
                </span>
              </a>
          </p>
          <p style="text-align: left;">
            <span style="font-size: 8pt;">
              <a href="/bible-study.html" target="_self">
                성경을 연구하거나 강의할 때 필요한 다양한 강의 PPT를 제공합니다.
              </a>
            </span>
          </p>

        </div>
      </div>
      <div class="grid-box width27 grid-h" style="width: 265px; ">
        <div class="module mod-line  deepest" style="min-height: 90px; ">


          <p>
            <a href="/mobile-info.html" target="_self">
              &nbsp;<img style="margin-right: 10px; float: left;" alt="icon-mobile-app" src="/images/main/icon-mobile-app.png" width="128" height="88">
                <span style="color: #000000;">
                  <strong>모바일 앱 다운로드</strong>
                </span>
              </a>
          </p>
          <p style="text-align: left;">
            <a href="/mobile-info.html" target="_self">
              이제 생애의 빛 SOS
              TV 방송을 스마트폰
              에서도 시청하실 수
              있습니다.
            </a>
          </p>

        </div>
      </div>
    </div>
  </section>
  
  
</div>