<?php
 use Model\FreightDriver; use Validate\IDMustBePositiveInt; goto Bf0YZ; j_49G: $differ = time() - $result["\x75\160\144\141\164\x65\137\164\x69\x6d\145"]; goto ysnEk; gCU9j: if ((int) $result["\164\x79\x70\145"] == 5) { goto HucOA; } goto Lk1HV; Bf0YZ: (new IDMustBePositiveInt())->goCheck(); goto XJWHy; BXmR1: return $this->result(0, ''); goto BjejK; bGWhl: $ordertype = 1; goto CsVVp; BjejK: TEOi0: goto ZL4cC; ysnEk: if (!($differ < $differ_time)) { goto eaNiU; } goto kOF1x; j5WzD: $id = $_GPC["\x69\x64"]; goto qAiCi; ZL4cC: $differ_time = 60; goto j_49G; Fguvq: goto oXm6B; goto BYqgK; hjBnP: pdo_update("\x6d\141\153\145\x5f\163\x70\145\145\x64\137\x6f\162\144\145\x72", array("\165\x70\x64\x61\x74\145\x5f\x74\x69\x6d\x65" => time()), array("\x69\x64" => $id)); goto gCU9j; mWWEz: eaNiU: goto grMZe; xZHQX: $data = $driverM->getScopeDriver($id); goto QCuYk; qAiCi: $result = pdo_get("\x6d\141\x6b\145\137\163\x70\145\x65\144\x5f\x6f\x72\x64\145\162", ["\x69\x64" => $id], ["\x74\x79\160\x65", "\x62\165\163\x69\x6e\x65\x73\x73\x5f\151\144", "\x67\145\164\x5f\x74\x69\155\145", "\x75\x70\144\x61\164\x65\x5f\164\151\x6d\145", "\157\x72\x64\145\x72\137\x63\x6f\x64\145", "\x70\141\x79\155\x65\156\x74"]); goto jvqnk; jvqnk: if (isset($result["\165\x70\x64\x61\164\145\137\164\151\x6d\145"])) { goto TEOi0; } goto BXmR1; QCuYk: oXm6B: goto aRXo6; XJWHy: global $_GPC; goto j5WzD; CsVVp: w5A1q: goto hjBnP; kOF1x: return $this->result(0, "\350\267\235\xe7\xa6\273\xe4\270\213\xe6\xac\241\xe5\x82\xac\345\x8d\225\xe8\xbf\230\345\x89\251" . ($differ_time - $differ) . "\347\xa7\222"); goto mWWEz; F2QNL: $driverM = new FreightDriver(); goto xZHQX; grMZe: $ordertype = 2; goto PlMF8; Lk1HV: $data = getScopeRider($id, $ordertype); goto Fguvq; BYqgK: HucOA: goto F2QNL; PlMF8: if (!is_numeric(substr($result["\147\x65\x74\x5f\164\x69\155\x65"], -1))) { goto w5A1q; } goto bGWhl; aRXo6: return $this->result(0, '', array("\160\141\171\137\160\x61\x72\141\155\x73" => array(), "\x61\x63\x63\x65\x70\x74\137\162\151\144\x65\x72" => get_business_rider($result["\x62\x75\x73\x69\x6e\x65\163\x73\137\x69\144"]) . $data));