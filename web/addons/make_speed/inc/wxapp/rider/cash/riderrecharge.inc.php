<?php
 goto jUKba; gcdXk: U1yAj: goto M0FFo; K9RCE: $money = !empty($_GPC["\155\x6f\156\x65\x79"]) ? intval($_GPC["\155\x6f\x6e\x65\x79"]) : 0; goto qylkQ; D9T1H: return $this->result(0, "\350\257\267\351\x80\211\346\213\xa9\345\205\205\345\x80\274\344\275\x99\xe9\242\235"); goto nUYKl; qylkQ: if (!empty($money)) { goto aQPp_; } goto D9T1H; EyFYz: $pay_params = $this->pay($params); goto Exc_G; jUKba: global $_W, $_GPC; goto K9RCE; Exc_G: if (!is_error($pay_params)) { goto U1yAj; } goto PcFvv; M0FFo: RiderCashLog($GLOBALS["\103\x55\122\x52\105\116\124\x5f\122\x49\x44\105\122"], $ordercode, $money, "\345\x85\x85\xe5\x80\xbc", 1, 1); goto fsycz; IRyvc: $ordercode = generate_order_code(16, "\155\x61\x6b\x65\137\163\x70\145\x65\144\137\162\x69\x64\x65\162\x5f\143\x61\x73\150\x6c\157\x67", "\157\162\x64\x65\162\137\x63\157\x64\145", "\x52\x43\x5a"); goto tCeN0; tCeN0: $params = array("\164\x69\144" => $ordercode, "\165\163\x65\x72" => $_W["\157\160\x65\x6e\151\x64"], "\x66\x65\x65" => $money, "\x74\151\x74\x6c\145" => "\350\xae\242\345\x8d\225\346\224\257\344\xbb\x98"); goto EyFYz; nUYKl: aQPp_: goto IRyvc; PcFvv: return $this->result(0, "\xe6\x94\xaf\344\273\x98\345\244\xb1\350\264\245\357\274\x8c\350\257\267\xe9\207\x8d\350\xaf\x95"); goto gcdXk; fsycz: return $this->result(0, '', array("\160\x61\x79\x5f\160\x61\x72\141\155\x73" => $pay_params));