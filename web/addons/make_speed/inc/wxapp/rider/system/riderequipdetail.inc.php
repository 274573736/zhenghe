<?php
 goto fHY_n; rruDt: mws2D: goto UTf2b; UTf2b: $result["\x69\155\x67"] = $_W["\x73\x69\164\145\x72\157\157\x74"] . "\x61\x64\144\x6f\156\163\x2f\155\x61\153\x65\x5f\x73\160\145\x65\144\57\143\157\x72\x65\x2f\x70\165\x62\x6c\x69\x63" . $result["\151\x6d\x67"]; goto tQhVP; mJD_c: $result = pdo_get("\x6d\141\153\145\x5f\x73\x70\145\x65\x64\x5f\145\161\x75\151\160", array("\151\x64" => $id), array("\x69\x64", "\x74\x69\x74\x6c\145", "\x69\x6d\x67", "\x70\162\151\143\x65", "\144\145\164\x61\x69\154", "\163\164\141\164\165\x73")); goto qgQi_; qgQi_: if (!empty($result)) { goto mws2D; } goto ZMxjv; mdReC: $id = !empty($_GPC["\x69\144"]) ? intval($_GPC["\x69\x64"]) : 0; goto mJD_c; fHY_n: global $_W, $_GPC; goto mdReC; ZMxjv: return $this->result(0, "\xe6\211\xbe\xe4\xb8\215\xe5\210\260\xe8\xbf\231\344\270\xaa\350\243\205\345\244\x87\xe4\272\x86\343\x80\202"); goto rruDt; tQhVP: return $this->result(0, '', $result);