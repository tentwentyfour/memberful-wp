;eval(function(p,a,c,k,e,r){e=function(c){return(c<62?'':e(parseInt(c/62)))+((c=c%62)<36?c.toString(36):String.fromCharCode(c+29))};if('0'.replace(0,e)==0){while(c--)r[e(c)]=k[c];k=[function(e){return r[e]||e}];e=function(){return'\\w{1,2}'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('N(document).h(\'app_ready\',1(e,2){4 $=N,l=$(\'#1b\'),D=$(\'#ddlConnectionDriver\'),s=$(\'.11-b-18\',\'#19\'),G=1(d){4 Q=\'conn-dbtype-\'+d;6 Q},o=1(d){d=d||D.m();4 E=l.v(\'3-db-k\');7(E){4 S=G(E);l.removeClass(S)}7(d){4 U=G(d);l.addClass(U)}l.v(\'3-db-k\',d||\'\')},F=1(q){q=q||8;7(q)2.g.q();$.14.open({items:{src:\'#1b\'},mainClass:\'i-form-modal\',k:\'inline\',closeOnBgClick:8},0)},P=1(){6 s.first().m()},R=1(){6 $(\'TBODY .18-item:checked\',\'#A\').length>0};2.g=a.createForm(l,{callbacks:{\'onInit\':1(){o()},\'onAfterReset\':1(){o()},\'onAfterPopulate\':1(){o()}}});D.h(\'13\',1(){o()});s.h(\'13\',1(){s.m($(j).m())});$(\'.n-11-b\',\'#19\').h(\'t\',1(){4 b=P();7(!b){a.c(2.5.9.selectAction);6 8}7(!R()){a.c(2.5.9.selectItem);6 8}4 C=1(b){a.M();2.L(b)};7(b==\'bulk_delete\'){a.12(2.5.9.bulkDeleteConfirm,1(){C(b)})}p{C(b)}6 8});$(\'#A\').h(\'t\',\'.n-i-10\',1(){4 Z=$(j).v(\'3-r\');a.12(2.5.9.deleteConfirm,1(){$(\'#hidConnectionId\').m(Z);2.L(\'10\')});6 8});$(\'#A\').h(\'t\',\'.i-edit\',1(){4 r=$(j).v(\'3-r\');3={\'B\':\'connections_get-i\',\'connection_id\':r};$.z({k:\'y\',x:2.5.K,3:3,J:\'I\'}).H(1(3){a.1a();7(3.f){2.g.populate(3.f,17);F()}p{}}).w(1(){a.1a()});a.M();6 8});$(\'#btnAddConnection\').h(\'t\',1(){F(17);6 8});$(\'#btnConnectionTest\').15({\'V\':1(){7(!2.g.T(\'test_connection\')){6 8}4 u=2.g.3(),3={\'B\':\'connections_test\',\'i\':u};4 n=j;j.W();$.z({k:\'y\',x:2.5.K,3:3,J:\'I\'}).H(1(3){7(3.f){7(3.f.f){c(2.5.9.connectionOk)}p{c(2.5.9.connectionFailed+\' \'+(3.f.error||\'\'))}}p{c(2.5.9.X)}}).w(1(){c(2.5.9.X)}).16(1(){n.O()});6 8}});$(\'#btnConnectionSave\').15({\'V\':1(){7(!2.g.T(\'i\')){6 8}4 u=2.g.3(),3={\'B\':\'connections_save\',\'i\':u};4 n=j;j.W();$.z({k:\'y\',x:2.5.K,3:3,J:\'I\'}).H(1(3){7(3.f){$.14.close();a.M();$(\'#ctrl_sub_action\').m(\'add\');2.L(\'reload\')}p{c(2.5.9.Y)}}).w(1(){c(2.5.9.Y)}).16(1(){n.O()});6 8}});o()});',[],74,'|function|app|data|var|options|return|if|false|messages|AppHelper|action|alert|dbType||result|connectionForm|on|connection|this|type|formContainer|val|btn|handleDbType|else|reset|id|bulkActionCtrlList|click|connectionParameters|attr|fail|url|POST|ajax|gridResults|ctrl|actionHandler|ctrlDbType|prevDbType|openConnectionPopup|getDbTypeClass|done|json|dataType|ajaxUrl|trigger|showLoading|jQuery|complete|getBulkAction|className|hasCheckedItems|prevDbTypeClass|validate|dbTypeClass|onClick|start|connectionTestFailed|connectionSaveFailed|connectionId|delete|bulk|confirm|change|magnificPopup|ariButton|always|true|select|ari_adminer_plugin|hideLoading|newConnectionForm'.split('|'),0,{}));