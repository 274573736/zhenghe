<?php
 goto kSEdA; I3KMG: $ordercode = generate_order_code(16, "\x6d\141\x6b\145\x5f\163\160\x65\x65\x64\x5f\162\151\x64\145\162\137\x63\x61\x73\150\x6c\157\x67", "\157\162\144\145\162\x5f\143\x6f\x64\x65", "\122\103\132"); goto YhGrT; wAdOv: if (!is_error($pay_params)) { goto fR0js; } goto icScf; b15oY: fR0js: goto gaGze; Hlm57: $pay_params = $this->pay($params); goto wAdOv; uOWrU: if (!empty($money)) { goto KOP3f; } goto Hn9OY; cpkX5: $money = !empty($_GPC["\x6d\157\x6e\145\171"]) ? intval($_GPC["\x6d\157\156\x65\171"]) : 0; goto uOWrU; gaGze: RiderCashLog($GLOBALS["\103\x55\x52\x52\105\116\124\137\x52\111\104\x45\x52"], $ordercode, $money, "\xe5\x85\205\345\200\xbc", 1, 1); goto LJbvC; icScf: return $this->result(0, "\xe6\x94\257\344\xbb\230\345\xa4\xb1\350\xb4\245\357\xbc\x8c\350\257\267\351\207\x8d\xe8\xaf\225"); goto b15oY; Hn9OY: return $this->result(0, "\350\xaf\267\351\x80\211\xe6\213\251\345\205\205\xe5\200\274\344\275\231\xe9\xa2\x9d"); goto rBcpm; rBcpm: KOP3f: goto I3KMG; kSEdA: global $_W, $_GPC; goto cpkX5; YhGrT: $params = array("\164\x69\144" => $ordercode, "\165\163\x65\162" => $_W["\x6f\x70\x65\156\151\144"], "\146\145\145" => $money, "\x74\151\x74\154\145" => "\xe8\256\xa2\xe5\215\225\xe6\224\xaf\344\xbb\230"); goto Hlm57; LJbvC: return $this->result(0, '', array("\x70\x61\x79\x5f\x70\141\x72\x61\155\163" => $pay_params));