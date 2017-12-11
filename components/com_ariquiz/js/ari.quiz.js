/** ARI Soft copyright
 * Copyright (C) 2008 ARI Soft.
 * All Rights Reserved.  No use, copying or distribution of this
 * work may be made except in accordance with a valid license
 * agreement from ARI Soft. This notice must be included on 
 * all copies, modifications and derivatives of this work.
 *
 * ARI Soft products are provided "as is" without warranty of 
 * any kind, either expressed or implied. In no event shall our 
 * juridical person be liable for any damages including, but 
 * not limited to, direct, indirect, special, incidental or 
 * consequential damages or other losses arising out of the use 
 * of or inability to use our products.
 *
**/

;eval(function(p,a,c,k,e,r){e=function(c){return(c<62?'':e(parseInt(c/62)))+((c=c%62)<36?c.toString(36):String.fromCharCode(c+29))};if('0'.replace(0,e)==0){while(c--)r[e(c)]=k[c];k=[function(e){return r[e]||e}];e=function(){return'\\w{1,2}'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('3.namespace(\'7.1y\');3.7.1y.1P={29:80,formatMailTemplate:B(a,b,c,d){4 e=b.G(\'MailTemplateId\');a.H=\'<a L="\'+3.7.u.T+\'M.P?A=\'+3.7.u.A+\'&Q=mailtemplate_update&mailTemplateId=\'+e+\'">\'+3.7.N.18(d)+\'</a>\'},formatScale:B(a,b,c,d){4 e=b.G(\'ScaleId\');a.H=\'<a L="\'+3.7.u.T+\'M.P?A=\'+3.7.u.A+\'&Q=resultscale_update&scaleId=\'+e+\'">\'+3.7.N.18(d)+\'</a>\'},formatQuiz:B(a,b,c,d){4 e=b.G(\'1i\');a.H=\'<a L="\'+3.7.u.T+\'M.P?A=\'+3.7.u.A+\'&Q=quiz_add&1z=\'+e+\'">\'+3.7.N.18(d)+\'</a>\'},formatQuizStatus:B(a,b,c,d){4 e=1e(d,10);R(2w(e))e=1;e=(e==1);4 f=(1j(1A)!="1k"&&1j(1A.1B)!="1k")?\'1A.1B\':\'1B\',g=3.7.u.1l+\'1s/\'+3.7.u.A+\'/1t/\',h=b.G(\'1i\'),i=e?\'2x$1Q|singleDeactivate\':\'2x$1Q|singleActivate\',j=e?\'1m.11\':\'2a.11\';a.H=\'<a L="2b:2c(0);" 2d="\'+f+\'(\\\'\'+i+\'\\\', {2e: {1z: \'+h+\'}}); X 1K;"><Y Z="\'+g+j+\'" 14="0" /></a>\'},formatQuizQuestion:B(a,b,c,d){4 e=b.G(\'1i\');a.H=\'<a L="\'+3.7.u.T+\'M.P?A=\'+3.7.u.A+\'&Q=2f&1z=\'+e+\'">\'+3.7.D.E(\'C.1L\')+\'</a>\'},formatQuizResult:B(a,b,c,d){4 e=b.G(\'1i\');a.H=\'<a L="\'+3.7.u.T+\'M.P?A=\'+3.7.u.A+\'&Q=results&1z=\'+e+\'">\'+3.7.D.E(\'C.1L\')+\'</a>\'},formatQuizCategory:B(a,b,c,d){4 e=b.G(\'1i\');a.H=\'<a L="\'+3.7.u.T+\'M.P?A=\'+3.7.u.A+\'&Q=questioncategory_list&1z=\'+e+\'">\'+3.7.D.E(\'C.1L\')+\'</a>\'},formatCategory:B(a,b,c,d){4 e=b.G(\'2y\');a.H=\'<a L="\'+3.7.u.T+\'M.P?A=\'+3.7.u.A+\'&Q=category_add&2z=\'+e+\'">\'+3.7.N.18(d)+\'</a>\'},formatBankCategory:B(a,b,c,d){4 e=b.G(\'2y\');a.H=\'<a L="\'+3.7.u.T+\'M.P?A=\'+3.7.u.A+\'&Q=bankcategory_add&2z=\'+e+\'">\'+3.7.N.18(d)+\'</a>\'},formatQCategory:B(a,b,c,d){4 e=b.G(\'QuestionCategoryId\');a.H=\'<a L="\'+3.7.u.T+\'M.P?A=\'+3.7.u.A+\'&Q=questioncategory_add&qCategoryId=\'+e+\'">\'+3.7.N.18(d)+\'</a>\'},formatTextTemplate:B(a,b,c,d){4 e=b.G(\'2A\');a.H=\'<a L="\'+3.7.u.T+\'M.P?A=\'+3.7.u.A+\'&Q=texttemplate_add&2B=\'+e+\'">\'+3.7.N.18(d)+\'</a>\'},formatCssTemplate:B(a,b,c,d){4 e=b.G(\'FileId\');a.H=\'<a L="\'+3.7.u.T+\'M.P?A=\'+3.7.u.A+\'&Q=template_add&2C=\'+e+\'">\'+3.7.N.18(d)+\'</a>\'},formatQuestions:B(a,b,c,d){4 e=b.G(\'2g\');4 f=b.G(\'1i\');4 g=3.7.N.18(d);4 h=g.U;R(h>3.7.1y.1P.29)g=g.substr(0,3.7.1y.1P.29)+\'...\';a.H=\'<a L="\'+3.7.u.T+\'M.P?A=\'+3.7.u.A+\'&Q=question_add&2D=\'+e+\'&1z=\'+f+\'">\'+g+\'</a>\'},formatBankQuestions:B(a,b,c,d){4 e=b.G(\'2g\')||b.G(\'BankQuestionId\');a.H=\'<a L="\'+3.7.u.T+\'M.P?A=\'+3.7.u.A+\'&Q=bank_add&2D=\'+e+\'">\'+3.7.N.18(d)+\'</a>\'},formatQTemplate:B(a,b,c,d){4 e=b.G(\'2A\');a.H=\'<a L="\'+3.7.u.T+\'M.P?A=\'+3.7.u.A+\'&Q=qtemplate_add&2B=\'+e+\'">\'+3.7.N.18(d)+\'</a>\'},formatResultScore:B(a,b,c,d){4 e=b.G(\'2h\')||0;4 f=b.G(\'2i\')||0;4 g=b.G(\'PercentScore\')||0;a.H=f+\' / \'+e+\' (\'+g+\' %)\'},formatResultDetails:B(a,b,c,d){4 e=b.G(\'StatisticsInfoId\');a.H=\'<a L="\'+3.7.u.T+\'M.P?A=\'+3.7.u.A+\'&Q=result&statisticsInfoId=\'+e+\'">\'+3.7.D.E(\'C.1L\')+\'</a>\'},formatPassed:B(a,b,c,d){4 e=1e(d,10);R(2w(e))e=0;a.H=3.7.D.E(e?\'C.Passed\':\'C.NoPassed\')},formatUser:B(a,b,c,d){a.H=d?d:3.7.D.E(\'C.Guest\')},formatQuestionsReorder:B(a,b,c,d){4 e=(1j(1A)!="1k"&&1j(1A.1B)!="1k")?\'1A.1B\':\'1B\',f=3.7.u.1l+\'1s/\'+3.7.u.A+\'/1t/\',g=I.getRecordIndex(b),h=I.1R(\'paginator\'),i=h.getTotalRecords(),j=b.G(\'2g\'),k=b.G(\'1i\');a.H=\'<a\'+(g==0?\' F="2E: 1S;"\':\'\')+\' L="2b:2c(0)" 2d="\'+e+\'(\\\'2f$1Q|orderup\\\', {2e: {2F: \'+j+\'}}); X 1K;"><Y Z="\'+f+\'uparrow.11" 14="0" 2j="2G"/></a>&19;\'+\'<a\'+(g>=(i-1)?\' F="2E: 1S;"\':\'\')+\' L="2b:2c(0)" 2d="\'+e+\'(\\\'2f$1Q|orderdown\\\', {2e: {2F: \'+j+\'}}); X 1K;"><Y Z="\'+f+\'downarrow.11" 14="0" 2j="2G"/></a>\'},formatUserResultDetails:B(a,b,c,d){a.H=\'<a L="\'+d+\'">\'+3.7.D.E(\'C.1L\')+\'</a>\'},formatExportQuizResults:B(a,b,c,d){4 e=(d&&d!="0");4 f=b.G(\'1i\');4 g=\'<2k name="\'+c.key+\'[\'+f+\']">\'+\'<A 1f="0"\'+(!e?\' 1T="1T"\':\'\')+\'>\'+3.7.D.E(\'C.No\')+\'</A>\'+\'<A 1f="1"\'+(e?\' 1T="1T"\':\'\')+\'>\'+3.7.D.E(\'C.Yes\')+\'</A>\'+\'</2k>\';a.H=g},formatQuestionStatData:B(a,b,c,d){4 e=3.1M.JSON.parse(d);4 f=6;4 g=\'<S 9="ariQuizResults">    		<v 9="ariQuizStatTrPos">    			<8 rowspan="#{2H}" 9="ariStatTdPos">#{1a}.</8>    			<8 9="1C">#{1U}</8>    			<8 9="ariStatTdScore">#{2I} / #{2J}</8>    		</v>    		<v 9="ariQuizStatTrCategory">    			<8 9="1C">#{2K}</8>    			<8>#{2L}</8>    		</v>    		<v 9="ariQuizStatTrQueType">    			<8 9="1C">#{2M}</8>    			<8>#{2N}</8>    		</v>    		<v 9="ariQuizStatTrQuestion">    			<8 9="1C">#{2O}</8>    			<8 9="2l">&19;</8>    		</v>\';R(e.2m){++f;g+=\'<v 9="ariQuizStatTrQueNote">    				<8 9="1C">#{2P}</8>    				<8 9="2l">#{2Q}</8>    			</v>\'};g+=\'<v 9="ariQuizStatTrTotalTime">    			<8 9="1C">#{2R}</8>    			<8>#{2S}</8>    		</v>    		<v 9="ariQuizStatTrQueStat">    			<8 9="ariStatTdStat" colspan="2">#{2T}</8>    		</v>    	</S>\';a.H=3.7.12.13(g,{1a:(1e(e.QuestionIndex,10)+1),2H:f,1U:3.7.D.E(\'C.2U\'),2K:3.7.D.E(\'C.QuestionCategory\'),2M:3.7.D.E(\'C.2V\'),2O:3.7.D.E(\'C.2n\'),2R:3.7.D.E(\'C.2W\'),2I:e.2i||0,2J:e.2h||0,2L:e.CategoryName||\'-\',2N:e.2V,2P:3.7.D.E(\'C.2m\'),2Q:e.2m,2S:3.7.widgets.dataTable.1P._formatDuration(e.2W),2T:3.7.1y.2X.2Y(e)});4 h=3.N.1D.1V(\'2l\',\'8\',a);R(h&&h.U>0){h=h[0];R(!h.id)h.id=3.N.1D.generateId();3.N.Event.onContentReady(h.id,B(){3.7.DOM.updateHtml(I.2Z,I.30)},1N,{\'2Z\':h,\'30\':e.2n})}}};3.7.1y.2X={renderCorrelationDDQuestion:B(a,b,c){X I.31(a,b,c)},31:B(a,b,c){4 d=c.1E;4 e={};R(b){16(4 i=0,l=b.U;i<l;i++){4 f=b[i];e[f[\'32\']]=f[\'33\']}};4 g={};R(a){16(4 i=0,l=a.U;i<l;i++){4 f=a[i];g[f[\'33\']]=f[\'1g\']}};4 h=\'<S F="J: 1F%;" 1u="0" 1v="0" 9="1w ariQuizStatCQ">			<v>				<w 9="1G">&19;</w>				<w 9="1G">#{34}</w>\'+(d?\'<w 9="1G">#{35}</w>\':\'\')+\'</v>			#{1b}		</S>\';4 j=\'<v 2j="2o">			<8 9="1G">#{36}</8>			<8 9="1G">#{17}</8>\'+(d?\'<8 9="1G">#{1H}</8>\':\'\')+\'</v>\';4 k=\'\';16(4 i=0,l=a.U;i<l;i++){4 f=a[i];4 m=f[\'32\'];4 n=\'\';R(1j(e[m])!=\'1k\'&&1j(g[e[m]])!=\'1k\'){n=g[e[m]]};k+=3.7.12.13(j,{36:f[\'tbxLabel\'],17:f[\'1g\'],1H:n})};X 3.7.12.13(h,{34:3.7.D.E(\'C.CorrectCorrelation\'),35:3.7.D.E(\'C.UserCorrelation\'),1b:k})},renderSingleQuestion:B(a,b,c){4 d=c.1E;4 e=b&&b.U>0?b[0][\'1n\']:1o;4 f=\'<S F="J: 1F%;" 1u="0" 1v="0" 9="1w  ariQuizStatSQ">			<v>				<w 9="V K" F="J: 1%;">#{1p}</w>\'+(d?\'<w 9="V K" F="J: 5%;">#{1c}</w>\':\'\')+\'<w 9="V K" F="J: 5%;">#{1q}</w>				<w 9="V" F="1d-W: O;">#{1r}</w>			</v>			#{1b}		</S>\';4 g=\'<v>			<8>#{1a}.</8>\'+(d?\'<8 9="K">#{1I}</8>\':\'\')+\'<8 9="K">#{1W}</8>			<8 W="O">#{17}</8>		</v>\';4 h=\'\';4 j=3.7.u.1l+\'1s/\'+3.7.u.A+\'/1t/\';16(4 i=0,l=a.U;i<l;i++){4 k=a[i];h+=3.7.12.13(g,{1a:(i+1),1I:(k[\'1n\']==e?\'<Y Z="\'+j+\'1m.11" 14="0" 1h="" />\':\'&19;\'),1W:(k[\'hidCorrect\']?\'<Y Z="\'+j+\'1m.11" 14="0" 1h="" />\':\'&19;\'),17:k[\'1g\']})};X 3.7.12.13(f,{1p:3.7.D.E(\'C.1X\'),1c:3.7.D.E(\'C.1O\'),1q:3.7.D.E(\'C.1Y\'),1r:3.7.D.E(\'C.1Z\'),1b:h})},renderMultipleQuestion:B(a,b,c){4 d=c.1E;4 e=[];R(b){16(4 i=0,l=b.U;i<l;i++){4 f=b[i];e.37(f[\'1n\'])}};4 g=\'<S F="J: 1F%;" 1u="0" 1v="0" 9="1w ariQuizStatMQ">			<v>				<w 9="V K" F="J: 1%;">#{1p}</w>\'+(d?\'<w 9="V K" F="J: 5%;">#{1c}</w>\':\'\')+\'<w 9="V K" F="J: 5%;">#{1q}</w>				<w 9="V" F="1d-W: O;">#{1r}</w>			</v>			#{1b}		</S>\';4 h=\'<v>			<8>#{1a}.</8>\'+(d?\'<8 9="K">#{1I}</8>\':\'\')+\'<8 9="K">#{1W}</8>			<8 W="O">#{17}</8>		</v>\';4 j=\'\';4 k=3.7.u.1l+\'1s/\'+3.7.u.A+\'/1t/\';16(4 i=0,l=a.U;i<l;i++){4 f=a[i];j+=3.7.12.13(h,{1a:(i+1),1I:(e.38(f[\'1n\'])>-1?\'<Y Z="\'+k+\'1m.11" 14="0" 1h="" />\':\'&19;\'),1W:(f[\'cbCorrect\']?\'<Y Z="\'+k+\'1m.11" 14="0" 1h="" />\':\'&19;\'),17:f[\'1g\']})};X 3.7.12.13(g,{1p:3.7.D.E(\'C.1X\'),1c:3.7.D.E(\'C.1O\'),1q:3.7.D.E(\'C.1Y\'),1r:3.7.D.E(\'C.1Z\'),1b:j})},renderMultipleSummingQuestion:B(a,b,c){4 d=c.1E;4 e=[];R(b){16(4 i=0,l=b.U;i<l;i++){4 f=b[i];e.37(f[\'1n\'])}};4 g=\'<S 1u="0" 1v="0" 9="1w ariQuizStatMSQ">			<v>				<w 9="V K" F="J: 1%;">#{1p}</w>\'+(d?\'<w 9="V K" F="J: 10%;">#{1c}</w>\':\'\')+\'<w 9="V" F="1d-W: O;">#{1r}</w>				<w 9="V K" F="J: 10%;">#{1U}</w>			</v>			#{1b}		</S>\';4 h=\'<v>			<8>#{1a}.</8>\'+(d?\'<8 9="K">#{1I}</8>\':\'\')+\'<8 W="O">#{17}</8>			<8 9="K">#{39}</8>		</v>\';4 j=\'\';4 k=3.7.u.1l+\'1s/\'+3.7.u.A+\'/1t/\';16(4 i=0,l=a.U;i<l;i++){4 f=a[i];j+=3.7.12.13(h,{1a:(i+1),1I:(e.38(f[\'1n\'])>-1?\'<Y Z="\'+k+\'1m.11" 14="0" 1h="" />\':\'&19;\'),39:f[\'tbxMSQScore\'],17:f[\'1g\']})};X 3.7.12.13(g,{1p:3.7.D.E(\'C.1X\'),1c:3.7.D.E(\'C.1O\'),1U:3.7.D.E(\'C.2U\'),1r:3.7.D.E(\'C.1Z\'),1b:j})},renderFreeTextQuestion:B(a,b,c){4 d=c.1E;4 e=b&&b.U>0?b[0][\'1g\']:\'\';4 f=\'<S F="J: 1F%;" 1u="0" 1v="0" 9="1w 3a">			<v>				<w 9="K" F="J: 1%;">#{1q}</w>\'+(d?\'<w F="1d-W: O;">#{1c}</w>\':\'\')+\'</v>			<v>				<8 9="K">#{3b}</8>\'+(d?\'<8 W="O">#{1H}</8>\':\'\')+\'</v>		</S>		<br/>		<S F="J: 1F%;" 1u="0" 1v="0" 9="1w">			<v>				<w 9="V K" F="J: 1%;">#{1p}</w>				<w 9="V K" F="\'+(d?\'J: 1%;\':\'\')+\'3c-space: nowrap;">#{3d}</w>\'+(d?\'<w 9="V" F="1d-W: O;">#{1r}</w>\':\'\')+\'</v>			#{1b}		</S>\';4 g=\'<v>			<8>#{1a}.</8>			<8 9="K">#{3e}</8>\'+(d?\'<8 W="O">#{17}</8>\':\'\')+\'</v>\';4 h=\'\';4 j=3.7.u.1l+\'1s/\'+3.7.u.A+\'/1t/\';16(4 i=0,l=a.U;i<l;i++){4 k=a[i];h+=3.7.12.13(g,{1a:(i+1),3e:(k[\'3f\']?\'<Y Z="\'+j+\'1m.11" 14="0" 1h="" />\':\'<Y Z="\'+j+\'2a.11" 14="0" 1h="" />\'),17:k[\'1g\']})};X 3.7.12.13(f,{1p:3.7.D.E(\'C.1X\'),1c:3.7.D.E(\'C.1O\'),3d:3.7.D.E(\'C.TextCI\'),1q:3.7.D.E(\'C.1Y\'),1r:3.7.D.E(\'C.1Z\'),3b:(c[\'2i\']==c[\'2h\']?\'<Y Z="\'+j+\'1m.11" 14="0" 1h="" />\':\'<Y Z="\'+j+\'2a.11" 14="0" 1h="" />\'),1H:e,1b:h})},renderMultiFreeTextQuestion:B(a,b,c){4 d=c[\'2n\'];4 e=d;4 f=d;4 g={};4 h={};R(a){16(4 i=0,l=a.U;i<l;i++){4 j=a[i];g[j[\'1n\']]={\'3g\':j[\'tbxAlias\'],\'17\':j[\'1g\'],\'ci\':j[\'3f\']}}}R(b){16(4 i=0,l=b.U;i<l;i++){4 k=b[i];h[k[\'1n\']]=k[\'1g\']}}16(4 m in g){4 n=g[m];4 o=n[\'17\'];4 p=n[\'ci\'];4 q=\'{$\'+n[\'3g\']+\'}\';f=f.3i(q,\'<20 9="3j">\'+o+\'</20>\');4 r=\'&19;\';4 s=1K;R(h[m]){r=h[m];s=((r==o)||(p&&r.21()==o.21()))}e=e.3i(q,\'<20 9="\'+(s?\'3j\':\'ariQuizMFTWrong\')+\'">\'+r+\'</20>\')}4 t=\'<S F="J: 1F%;" 1u="0" 1v="0" 9="1w 3a">			<v>				<w F="1d-W: O;">#{1q}</w>			</v>			<v>				<8 W="O">#{3k}</8>			</v>			<v>				<w F="1d-W: O;">#{1c}</w>			</v>			<v>				<8 W="O">#{1H}</8>			</v>		</S>\';X 3.7.12.13(t,{1c:3.7.D.E(\'C.1O\'),1q:3.7.D.E(\'C.1Y\'),1H:e,3k:f})},renderHotSpotQuestion:B(a,b,c){4 d=b?b[\'x1\']:-1;4 e=b?b[\'y1\']:-1;4 f=!3.1M.3l(c[\'3m\'])?c[\'3m\']:{};4 x=1e(a[\'x1\'],10);4 y=1e(a[\'y1\'],10);4 g=1e(a[\'x2\'],10)-1e(a[\'x1\'],10);4 h=1e(a[\'y2\'],10)-1e(a[\'y1\'],10);4 i=f&&!3.1M.3l(f[\'3n\'])?f[\'3n\']:1o;4 j=\'<22 F="23: 3o; 1d-W: O;" id="divAriHotSpotWrap">			<22 id="divAriHotSpotCorrect" F="O: #{x}px; 2o: #{y}px; J: #{J}px; 2r: #{2r}px; font-size: 0; 23: 3p; z-M: 2; background: 3c; 3q: 0.5; 2s:alpha(3q=50);">&19;</22>			<Y id="imgAriHotSpotMarker" F="#{F};23: 3p; z-M: 2;" Z="#{3r}" />			<Y id="imgAriHotSpot" F="23: 3o;" Z="#{3s}" />		</22>\';X 3.7.12.13(j,{x:x,y:y,J:g,2r:h,F:((d<0||e<0)?\'display: none\':(\'2o: \'+(e-5)+\'px; O: \'+(d-5)+\'px;\')),3r:3.7.u.1l+\'1s/\'+3.7.u.A+\'/1t/circle.gif\',3s:3.7.u.1l+\'M.P?A=\'+3.7.u.A+\'&Q=showHotSpot&2C=\'+i})},2Y:B(a,b){4 c=a.QuestionClassName;4 d=a.QuestionData;4 e=a.UserData;b=1j(b)!=\'1k\'?b:1N;a.1E=b;4 f=\'\';R(c&&1j(I[\'3t\'+c])!=\'1k\'){f=(I[\'3t\'+c])(d,e,a)}X f}};3.7.u.2t=B(a){I.3u(a)};3.7.u.2t.prototype={constructor:3.7.u.2t,3u:B(a){a=a||{};I.24=3.1M.merge(I.3v,a);I.3w()},3w:B(){4 c=3.N.1D;4 d=I.24;c.1V(d.25,1o,d.26,B(a){4 b=document.createElement(\'3x\');b.2u=\'1S\';b.className=d.3y;b.id=I.27+a.id;b.1f=I.2v(a);c.insertAfter(b,a)},I,1N)},2v:B(a,b){b=b||1K;4 c=1o;4 d=3.N.1D.1R(a);R(d){4 e=d.3z?d.3z.21():1o;3A(e){1x\'3x\':4 f=d.2u?d.2u.21():\'1d\';3A(f){1x\'file\':1x\'1d\':1x\'1S\':c=d.1f;28;1x\'checkbox\':c=d.checked?(d.1f?d.1f:\'1\'):\'\';28}28;1x\'textarea\':1x\'2k\':c=d.1f;28}}X(c&&b)?3.1M.trim(c):c},getFilterValues:B(){4 c={};4 d=3.N.1D;4 e=I.24;d.1V(e.25,1o,e.26,B(a){4 b=d.1R(I.27+a.id);c[a.id]=b.1f},I,1N);X c},saveFilterValues:B(){4 c=3.N.1D;4 d=I.24;c.1V(d.25,1o,d.26,B(a){4 b=c.1R(I.27+a.id);b.1f=I.2v(a)},I,1N)},27:\'dfmHid_\',3v:{26:1o,25:\'3B-2s\',3y:\'3B-hid-2s\'}};',[],224,'|||YAHOO|var|||ARISoft|td|class|||||||||||||||||||||page|tr|th||||option|function|Label|languageManager|getMessage|style|getData|innerHTML|this|width|ariCenter|href|index|util|left|php|task|if|table|adminBaseUrl|length|title|align|return|img|src||png|core|format|border||for|answer|stripTags|nbsp|pos|items|lblUser|text|parseInt|value|tbxAnswer|alt|QuizId|typeof|undefined|baseUrl|tick|hidQueId|null|lblPos|lblCorrect|lblAnswer|components|images|cellpadding|cellspacing|adminlist|case|Quiz|quizId|Joomla|submitbutton|ariStatTdLabel|Dom|ShowUserAnswer|100|ariLeft|userAnswer|uHtml||false|View|lang|true|User|formatters|ajax|get|hidden|selected|lblScore|getElementsByClassName|cHtml|NumberPos|Correct|Answer|span|toLowerCase|div|position|config|filterElClassName|container|HID_PREFIX|break|DATA_LENGTH|publish_x|javascript|void|onclick|query|question_list|QuestionId|MaxScore|UserScore|valign|select|ariStatTdQuestion|QuestionNote|Question|top|||height|filter|dataFilterManager|type|_getElementValue|isNaN|quiz_list|CategoryId|categoryId|TemplateId|templateId|fileId|questionId|visibility|queId|absmiddle|posRowSpan|uScore|mScore|lblCategory|category|lblQuestionType|questionType|lblQuestion|lblNote|questionNote|lblTotalTime|totalTime|questionStat|Score|QuestionType|TotalTime|statistics|getStatistics|element|content|renderCorrelationQuestion|hidLabelId|hidAnswerId|lblCorrectCorrelation|lblUserCorrelation|label|push|indexOf|score|ariQuizStatFQ|uImg|white|lblTextCI|imgCI|cbCI|alias||replace|ariQuizMFTRight|correctAnswer|isUndefined|Files|hotspot_image|relative|absolute|opacity|imgCircle|hotSpotImg|render|init|_defaultConfig|_initElements|input|filterHidClassName|tagName|switch|dfm'.split('|'),0,{}));