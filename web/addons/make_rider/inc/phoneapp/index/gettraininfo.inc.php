<?php
 use Server\app\Token; goto RsYrM; RsYrM: global $_W, $_GPC; goto zIVvN; YE8Mf: $result = load()->object("\x71\165\145\x72\x79")->from("\x6d\141\x6b\x65\137\163\160\x65\145\x64\137\164\162\141\151\x6e\x5f\160\157\x69\x6e\x74", "\x70")->innerjoin("\155\141\153\x65\137\163\x70\145\145\144\137\x74\x72\141\x69\x6e\137\162\151\x64\x65\162", "\x72")->on(array("\x70\x2e\x69\144" => "\162\x2e\x74\x72\141\151\156\137\x69\x64"))->where(array("\162\x2e\x72\x69\x64\145\x72\x5f\x69\x64" => $rider_id))->get(); goto g2Vyx; zIVvN: $rider_id = Token::getCurrentRid(); goto YE8Mf; g2Vyx: !empty($result["\x74\151\x6d\145"]) && ($result["\x74\151\155\x65"] = date("\x59\x2d\x6d\x2d\144", $result["\164\x69\155\x65"])); goto qbj03; qbj03: return $this->result(0, '', $result);