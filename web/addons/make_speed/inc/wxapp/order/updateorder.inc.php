<?php
 use Validate\IDMustBePositiveInt; goto u0yNV; kfsxk: if (!is_numeric(substr($result["\147\145\x74\137\x74\151\x6d\x65"], -1))) { goto DvZe0; } goto CIdkr; GXRYd: goto nV96L; goto TVgOg; K2qFV: if (!is_error($pay_params)) { goto Ru1U5; } goto YsI8e; m_QQR: Q4J33: goto cJcjg; AxbGr: if (!($differ < $differ_time)) { goto UQcPd; } goto vQ0S8; It9wF: return $this->result(0, ''); goto vat62; H14JM: TWnC0: goto J54gg; TZrRO: pdo_update("\155\141\153\145\137\x73\x70\145\x65\144\x5f\157\x72\144\x65\x72", array("\165\x70\144\141\x74\x65\x5f\164\151\x6d\145" => time()), array("\x69\144" => $id)); goto DIG_8; J54gg: $orderCode = generate_order_code(18, "\155\141\x6b\x65\137\163\160\145\x65\144\x5f\x75\x73\x65\x72\137\x63\x61\163\150\154\157\x67", "\157\162\144\x65\x72\137\143\x6f\144\145", "\130\106"); goto bJ0zs; e1Mbf: if (!($result["\x70\x61\x79\x6d\x65\x6e\164"] == 3)) { goto QyWT1; } goto m1LWB; ytZea: $data = $driverM->getScopeDriver($id); goto UrQkf; k2t1y: return $this->result(0, "\xe6\x9b\xb4\346\226\xb0\xe6\x88\x90\345\212\237\xef\274\x81", array("\x61\143\x63\145\x70\x74\x5f\162\151\x64\x65\162" => getScopeRider($id, $ordertype))); goto LeLhU; I2y3y: if (!(empty($payment) || empty($small_price))) { goto zmxK4; } goto TZrRO; E9AKD: goto l3_Uq; goto m_QQR; MNW3Z: if (isset($result["\x75\160\x64\x61\x74\145\137\164\x69\155\x65"])) { goto x_t9N; } goto It9wF; m1LWB: return $this->result(0, "\xe7\216\xb0\351\207\x91\xe6\x94\xaf\344\273\230\xe6\227\240\xe6\xb3\x95\344\275\277\xe7\x94\xa8\xe5\212\xa0\xe5\260\217\xe8\xb4\271"); goto k6XnQ; piI3n: $payment = !empty($_GPC["\160\x61\171\137\155\145\164\150\157\x64"]) ? $_GPC["\x70\x61\171\x5f\x6d\x65\164\150\157\144"] : 0; goto H32rd; H32rd: $result = pdo_get("\x6d\x61\153\x65\137\x73\160\145\145\x64\x5f\x6f\x72\x64\x65\x72", array("\x69\144" => $id), array("\164\171\160\145", "\x62\x75\163\x69\156\145\163\163\137\151\x64", "\147\x65\x74\x5f\x74\x69\x6d\145", "\x75\160\x64\141\164\x65\x5f\x74\x69\x6d\x65", "\157\162\144\x65\162\137\x63\x6f\144\145", "\160\x61\x79\155\145\156\x74")); goto MNW3Z; Fc293: return $this->result(0, '', array("\160\141\x79\137\160\x61\162\141\x6d\163" => $pay_params, "\141\143\143\x65\x70\x74\137\162\151\144\145\162" => getScopeRider($id, $ordertype))); goto GXRYd; OgLlS: addCashLog($GLOBALS["\x43\125\x52\x52\x45\116\124\x5f\x55\123\x45\x52"], $orderCode, $small_price, 0, "\xe4\xbd\231\xe9\xa2\x9d\xe5\x8a\240\xe5\260\x8f\350\264\xb9", $id, 1); goto k2t1y; bGBmg: pdo_update("\x6d\x61\153\145\x5f\163\x70\145\145\144\x5f\x6f\x72\x64\x65\162", $data, array("\151\x64" => $id)); goto x5K80; e19F2: if (empty($small_price)) { goto DvQxv; } goto XwiQa; x5K80: updateUserMoney($GLOBALS["\103\125\x52\x52\105\116\124\x5f\x55\x53\105\x52"], $small_price); goto OgLlS; NiQeu: DvZe0: goto I2y3y; NZeQb: zmxK4: goto VHnjR; rmcWA: $differ = time() - $result["\x75\x70\144\141\164\x65\137\x74\x69\x6d\x65"]; goto bFS7t; gNp7H: return $this->result(0, '', array("\160\141\171\137\160\141\162\141\155\163" => array(), "\141\143\x63\145\x70\x74\137\x72\x69\x64\145\x72" => get_business_rider($result["\142\x75\163\151\156\x65\x73\x73\x5f\x69\x64"]) . $data)); goto NZeQb; yeHo1: $params = array("\x74\x69\144" => $orderCode, "\x75\x73\x65\x72" => $_W["\157\x70\x65\x6e\151\x64"], "\146\145\x65" => sprintf("\45\56\62\146", $small_price), "\164\151\164\x6c\145" => "\xe8\xae\242\345\215\x95\xe6\224\xaf\344\xbb\x98"); goto kyq9J; cm0Mk: $data = array("\x75\160\x64\141\x74\145\137\164\151\155\x65" => time(), "\163\x6d\141\154\154\137\160\x72\x69\x63\x65\x20\x2b\x3d" => $small_price, "\x70\x61\171\x5f\160\162\151\x63\x65\x20\x2b\x3d" => $small_price, "\164\x6f\164\x61\154\x5f\160\x72\151\x63\x65\x20\x2b\x3d" => $small_price); goto bGBmg; kyq9J: $pay_params = $this->pay($params); goto K2qFV; X_MC8: Tvtg8: goto fZu7H; ZgLCR: $differ_time = 60; goto EF9cc; XwiQa: $differ_time = 30; goto rmcWA; E521D: global $_W, $_GPC; goto ZiPEz; Z4iOS: DvQxv: goto ZgLCR; YsI8e: return $this->result(0, "\xe6\x94\257\344\xbb\230\xe5\244\xb1\350\xb4\245\xef\xbc\214\350\257\267\351\x87\215\xe8\xaf\x95"); goto T8p83; u0yNV: (new IDMustBePositiveInt())->goCheck(); goto E521D; xXAis: UQcPd: goto H14JM; f46Nb: $small_price = !empty($_GPC["\164\151\160\x5f\155\157\156\x65\171"]) ? sprintf("\x25\x2e\x32\146", $_GPC["\164\x69\160\x5f\x6d\x6f\156\x65\171"]) : 0; goto piI3n; vat62: x_t9N: goto e19F2; k6XnQ: QyWT1: goto cm0Mk; ZiPEz: $id = $_GPC["\151\144"]; goto f46Nb; DIG_8: if ((int) $result["\164\171\x70\x65"] == 5) { goto Q4J33; } goto j111E; L1Oso: return $this->result(0, "\350\267\235\347\246\273\344\270\213\346\254\xa1\xe5\x8a\240\xe8\264\xb9\350\277\230\345\211\251" . ($differ_time - $differ) . "\xe7\xa7\222"); goto X_MC8; CIdkr: $ordertype = 1; goto NiQeu; EF9cc: $differ = time() - $result["\x75\160\x64\141\164\x65\x5f\x74\151\155\145"]; goto AxbGr; UrQkf: l3_Uq: goto gNp7H; VHnjR: if ($payment == 1) { goto B0dDv; } goto NW2wi; j111E: $data = getScopeRider($id, $ordertype); goto E9AKD; vQ0S8: return $this->result(0, "\xe8\xb7\235\xe7\xa6\273\xe4\xb8\213\346\254\xa1\345\x82\254\xe5\215\225\350\277\x98\xe5\211\xa9" . ($differ_time - $differ) . "\347\247\x92"); goto xXAis; bFS7t: if (!($differ < $differ_time)) { goto Tvtg8; } goto L1Oso; T8p83: Ru1U5: goto Fc293; bJ0zs: $ordertype = 2; goto kfsxk; fZu7H: goto TWnC0; goto Z4iOS; NW2wi: addCashLog($GLOBALS["\103\x55\122\x52\x45\x4e\x54\x5f\x55\x53\x45\122"], $orderCode, $small_price, 0, "\345\xbe\256\344\277\241\xe5\212\xa0\xe5\260\x8f\350\xb4\271", $id, 0); goto yeHo1; cJcjg: $driverM = new Model\FreightDriver(); goto ytZea; TVgOg: B0dDv: goto e1Mbf; LeLhU: nV96L: