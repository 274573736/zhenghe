<?php
 goto Rs2Rp; WgPYg: if (!$config) { goto pxMRu; } goto vwLIN; NiiLh: $config = $configM->gets($field); goto WgPYg; YNB2B: if (!$config) { goto ln30M; } goto JRTEp; qdp4z: $field = ["\x70\151\156\144\145\170\x5f\151\143\x6f\x6e"]; goto NiiLh; Vd911: $config = $configM->replaceImgUrl($config); goto YNB2B; vwLIN: $config = isset($config["\x70\x69\x6e\144\x65\170\137\x69\x63\157\x6e"]) ? @unserialize($config["\x70\x69\156\144\x65\x78\x5f\151\x63\x6f\x6e"]) : ''; goto Vd911; JRTEp: return $this->result(0, "\x73\x75\x63\143\x65\163\163", $config); goto IYDka; LGRpH: pxMRu: goto NCva1; IYDka: ln30M: goto LGRpH; Rs2Rp: $configM = new \Model\Config(); goto qdp4z; NCva1: return $this->result(0, "\156\x75\154\x6c", "\157\153");