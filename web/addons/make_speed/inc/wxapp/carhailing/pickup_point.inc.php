<?php
 goto aerv2; I__BS: jLCnM: goto akkih; lbcBC: $field = ["\x69\x64", "\154\141\x74\x69\164\x75\144\145", "\x6c\157\156\x67\151\164\x75\144\145", "\141\x64\144\162\145\163\163"]; goto cPeI0; GDAcT: return $this->result(0, "\156\x75\154\154", "\x6f\x6b"); goto I__BS; ogfSy: $where = ["\143\151\x74\171\137\151\144" => $cityId, "\x75\156\x69\x61\x63\151\144" => $GLOBALS["\165\x6e\x69\141\143\151\x64"], "\163\x74\x61\x74\x75\x73" => 1]; goto lbcBC; WXBgB: $cityId = $this->request->param("\143\151\x74\171\137\x69\x64"); goto GNqPO; cPeI0: $point = pdo_get("\x6d\x61\153\x65\137\163\160\x65\x65\x64\137\143\141\x72\x5f\x70\151\143\153\x75\x70\x5f\x70\157\151\x6e\164", $where, $field); goto yvs5_; RmsZd: zSE3D: goto ogfSy; GNqPO: if (!(!$cityId && !is_numeric($cityId))) { goto zSE3D; } goto fM3U4; aerv2: defined("\111\116\137\x49\101") or exit("\x41\x63\x63\145\x73\x73\x20\104\145\x6e\151\145\x64"); goto WXBgB; yvs5_: if ($point) { goto jLCnM; } goto GDAcT; fM3U4: return $this->result(0, "\xe5\x9f\216\345\270\202\345\220\x8d\xe9\224\x99\350\xaf\xaf\x21"); goto RmsZd; akkih: return $this->result(0, "\163\165\143\x63\x65\163\x73", $point);