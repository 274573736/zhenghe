<?php
 use Server\DesignateDriver; use Model\Config; use Server\distribution\Order; use Server\app\Token; goto uLYvL; prWfb: $type = $_GPC["\164\x79\160\145"]; goto kfy0A; A8Vmc: technicianComplete($id, intval($rider_id)); goto xrpJ0; CV3a0: $pickcode = pdo_get("\155\141\x6b\145\x5f\x73\x70\145\x65\x64\137\157\x72\144\145\x72\x5f\x70\x69\143\153\x63\157\144\x65", array("\157\162\x64\145\x72\137\x69\x64" => $id), array("\160\x69\x63\x6b\x5f\x63\157\144\x65", "\145\x6e\x64\137\143\x6f\x64\x65")); goto WoMnd; yueBJ: $rider_id = Token::getCurrentRid(); goto VQnKT; W5pWh: $driver = pdo_get("\155\x61\153\x65\137\163\x70\x65\145\x64\137\x72\151\144\x65\x72\x5f\x64\x72\151\x76\x65\x72", ["\162\151\144\145\162\x5f\x69\x64" => $rider_id], ["\x74\x69\144"]); goto SHh3B; qnEvE: $upData["\164\x72\151\144"] = $trid; goto V57Hf; OdeCb: pdo_update("\x6d\x61\x6b\x65\137\163\160\x65\145\x64\x5f\x6f\x72\144\x65\x72\x5f\160\151\143\153\143\x6f\x64\x65", array("\145\x6e\144\x5f\x63\x6f\144\x65" => $endcode), array("\x6f\x72\144\145\162\137\151\144" => $id)); goto kvBTl; yra1E: if (!($type == 0)) { goto RMYIM; } goto LUtMx; iM9oO: if (empty($setting["\x76\x61\154\x75\x65"])) { goto zloNW; } goto Ez99y; wqBoZ: return $this->result(0, "\345\x8f\x96\344\xbb\xb6\xe6\210\220\345\x8a\x9f\xef\xbc\x81", array("\x6f\x72\x64\145\x72\137\x69\144" => $id)); goto scCjx; DQJWu: kucvT: goto zZ10e; SMFcI: update_eleme_location($id, $rider["\x6c\x61\x74"], $rider["\x6c\x6e\x67"]); goto nPdfG; L3O5p: (new DesignateDriver())->deliveryOrder($longitude, $latitude, $id); goto x2D1z; vWLH2: if (!($order["\x74\x79\x70\x65"] == 0)) { goto r1yO6; } goto ZMQjq; ZEt2d: $rider = pdo_get("\x6d\141\x6b\x65\x5f\163\x70\x65\145\x64\137\x72\151\144\x65\x72\137\151\156\146\x6f", array("\162\x69\x64\145\x72\137\151\x64" => $rider_id), array("\154\x61\x74", "\154\x6e\x67")); goto SMFcI; WNlw5: DgsP8: goto L3O5p; scCjx: mJ4WD: goto Hlj_z; eu2lZ: rider_invite_user($order["\x75\163\x65\x72\x5f\x69\144"]); goto RsfYg; zZ10e: r1yO6: goto AS4ia; suMm_: $longitude = $_GPC["\154\156\147"]; goto CV3a0; D15Oa: rider_usercomplete_order($order["\x75\163\x65\x72\137\x69\144"]); goto AtgXZ; kM8lW: freightCompleteOrder($id, intval($rider_id)); goto B4sGd; vBAXE: TarUT: goto A8Vmc; t4bD8: pdo_update("\x6d\141\153\145\137\163\160\x65\145\x64\x5f\x6f\x72\144\145\x72\x5f\162\151\144\145\162", array("\145\156\x64\137\151\x6d\147" => $endimg), array("\x6f\162\144\x65\x72\x5f\x69\x64" => $id)); goto G_dgj; SHh3B: $trid = \Mclass\LieYing::addTrack($driver["\x74\x69\144"]); goto qnEvE; chL0M: return $this->result(0, "\xe8\257\267\xe4\270\212\344\xbc\240\xe7\x85\xa7\xe7\211\207\357\274\x81"); goto XYMRc; dbo7Y: kzLTX: goto v2rmM; n04sx: $endcode = generate_pick_code(1); goto tUZ22; kAKFu: $tpl->orderComplete($id); goto miyc7; miyc7: return $this->result(0, "\xe6\x88\x90\xe5\212\237\xe9\200\x81\350\276\276\357\xbc\x81", array("\x6f\162\144\x65\x72\x5f\151\144" => $id)); goto Lw0Qf; YC8Qe: $switch = pdo_getall("\155\141\x6b\x65\137\x73\x70\x65\145\144\137\x73\x65\x74\x74\151\x6e\x67", array("\153\x65\x79" => array("\147\145\x74\143\157\x64\x65\137\163\x77\x69\164\x63\x68", "\145\x6e\x64\x63\x6f\144\145\137\163\x77\151\164\143\150", "\145\x78\160\145\x63\164\x5f\x74\x69\155\145\144\60"), "\165\x6e\151\x61\143\x69\x64" => $GLOBALS["\x75\x6e\x69\141\143\151\x64"]), array("\153\x65\x79", "\x76\141\154\165\145")); goto BC5aV; XkeKy: FWS2f: goto cLY5w; Mz9Rl: goto iJhgO; goto WNlw5; x2D1z: iJhgO: goto Cp069; mjJ72: $take = isset($switchImg["\x74\x61\153\x65\x5f\160\150\157\x74\157"]) ? $switchImg["\164\x61\153\x65\137\x70\150\157\x74\157"] : 0; goto s32dj; Aey3T: BpP7u: goto cYjDD; npInx: V3CBf: goto OdeCb; Yh1Tv: $img = !empty($_GPC["\x67\x6f\157\x64\x73\x5f\x69\155\x67"]) ? trim($_GPC["\x67\x6f\x6f\x64\163\x5f\151\155\x67"]) : ''; goto iTOPZ; LUtMx: if (!($take == 0)) { goto y5OLf; } goto jZ78e; Cp069: $tpl = new \Mclass\SendTpl(); goto kAKFu; xXmWF: ip3Rz: goto kM8lW; ZMQjq: if (!(!empty($pickcode["\160\151\x63\153\x5f\x63\157\x64\x65"]) && $pickcode["\x70\151\x63\x6b\137\143\157\144\x65"] != $code && empty($switch["\x67\x65\164\143\157\144\x65\137\163\x77\x69\x74\143\x68"]))) { goto kucvT; } goto vOMd8; kwoB1: if (!($receive == 0)) { goto gZGWT; } goto s3_sl; s3_sl: if ($endimg) { goto IWvFh; } goto u_s4M; jIdU8: if (!($type == 1)) { goto Lnhk9; } goto kwoB1; aB0ql: send_aliyun_sms($end["\145\x6e\144\x5f\x70\x68\157\x6e\x65"], array("\143\x6f\144\x65" => $endcode), "\141\x6c\x69\137\x67\x6f\x74\157\x5f\x74\x65\x6d\160"); goto npInx; HGtlQ: get_oneorder_coupon($order["\165\163\x65\162\x5f\x69\144"]); goto eu2lZ; AbPxK: $expect_timed = get_mapapi_time($end["\x62\145\x67\151\x6e\x5f\x6c\x6e\147"] . "\x2c" . $end["\x62\145\147\151\x6e\137\154\141\x74"], $end["\x65\x6e\x64\137\154\x6e\x67"] . "\x2c" . $end["\x65\156\144\x5f\x6c\141\164"]); goto iYsBv; iTOPZ: $endimg = !empty($_GPC["\145\x6e\144\x5f\151\155\147"]) ? trim($_GPC["\x65\x6e\144\x5f\x69\155\x67"]) : ''; goto prWfb; ltH_o: if (!(!empty($pickcode["\145\156\144\137\x63\157\x64\x65"]) && $pickcode["\x65\x6e\x64\137\x63\157\144\x65"] != $code && empty($switch["\x65\x6e\144\x63\x6f\x64\x65\x5f\x73\167\151\x74\x63\150"]) && $order["\164\x79\160\x65"] != 3)) { goto DcztV; } goto rNoNq; m_LW5: if ($order["\164\171\160\x65"] == 6) { goto TarUT; } goto XZDUz; DRTj0: if (!($order["\x74\x79\160\145"] == 3 && $order["\143\150\141\162\147\137\164\x79\x70\x65"] == 2)) { goto kzLTX; } goto fvJbI; IJBzC: $expect_timed = $expect_timed !== '' ? date("\x48\72\151", time() + $expect_timed) : ''; goto j8gvB; vOMd8: return $this->result(0, "\350\257\xb7\350\xbe\x93\xe5\x85\245\346\255\xa3\347\241\xae\347\x9a\204\xe5\x8f\x96\344\273\xb6\347\240\x81\357\274\201"); goto DQJWu; at_Xl: if (empty($end["\x62\x65\x67\x69\156\x5f\x61\x64\144\162\145\163\163"])) { goto FWS2f; } goto AbPxK; BioYU: $switchImg = Config::getm(["\164\x61\x6b\145\x5f\160\x68\x6f\x74\157", "\162\145\x63\145\x69\x76\145\137\x70\150\157\164\157"]); goto mjJ72; Ez99y: $expect_timed = $expect_timed + $setting["\x76\141\154\x75\145"] * 60; goto yIxZk; q41nM: aTIXT: goto yT7cJ; uLYvL: global $_W, $_GPC; goto yueBJ; InQO7: $expect_timed = 0; goto at_Xl; I3ddX: IWvFh: goto kNDR_; AtgXZ: Order::complateOrder($id); goto qmfQw; cYjDD: $latitude = $_GPC["\x6c\x61\x74"]; goto suMm_; tUZ22: if (empty($endcode)) { goto V3CBf; } goto aB0ql; V57Hf: $redis->set("\144\162\x69\166\145\x72" . $rider_id, $id); goto dbo7Y; B4sGd: goto G3ivX; goto vBAXE; IbzS_: if (!(!in_array($order["\x74\171\160\145"], [3, 5, 6]) && empty($end["\145\x78\x74\145\156\163\151\157\156\x5f\x6e\165\x6d\142\145\x72"]) && empty($switch["\145\x6e\144\143\x6f\x64\x65\137\x73\x77\151\x74\x63\150"]))) { goto knDJP; } goto n04sx; ZFKBb: DcztV: goto lvTbQ; AS4ia: $up = pdo_update("\x6d\x61\x6b\x65\137\x73\160\x65\145\x64\137\x6f\x72\x64\145\x72", array("\163\164\x61\x74\165\x73" => 4), array("\151\x64" => $id)); goto iIS9V; a6pCn: $code = !empty($_GPC["\x67\157\x6f\144\x73\137\x63\x6f\x64\145"]) ? trim($_GPC["\x67\157\157\x64\x73\137\143\x6f\x64\x65"]) : ''; goto Yh1Tv; nPdfG: $end = pdo_get("\155\141\x6b\x65\x5f\x73\160\145\x65\144\137\157\x72\144\145\162\x5f\x61\144\x64\162\145\x73\x73", array("\x6f\x72\x64\145\162\x5f\x69\x64" => $id), array("\145\170\164\x65\x6e\163\x69\157\x6e\137\x6e\x75\x6d\142\145\162", "\x62\145\147\x69\x6e\x5f\x61\144\144\162\x65\163\x73", "\145\x6e\144\x5f\x70\x68\x6f\x6e\145", "\142\145\147\x69\156\x5f\154\141\x74", "\x62\x65\147\151\156\x5f\154\156\x67", "\145\x6e\x64\137\154\x61\164", "\x65\x6e\x64\137\x6c\x6e\147")); goto InQO7; kfy0A: if (in_array($type, [0, 1])) { goto BpP7u; } goto SNG9G; yT7cJ: $setting = pdo_get("\155\x61\153\x65\137\163\x70\x65\145\x64\x5f\163\145\164\x74\151\156\147", array("\x6b\x65\171" => "\x65\170\160\x65\143\164\x5f\x74\151\x6d\145\144" . $order["\164\171\x70\x65"], "\165\x6e\x69\141\x63\x69\x64" => $GLOBALS["\165\x6e\x69\141\143\x69\x64"]), array("\166\141\154\165\x65")); goto iM9oO; v2rmM: pdo_update("\x6d\x61\x6b\x65\x5f\x73\x70\145\145\x64\137\157\162\144\x65\162\x5f\162\x69\144\145\x72", $upData, array("\157\162\144\145\x72\x5f\151\144" => $id)); goto IbzS_; Lw0Qf: Lnhk9: goto v0dKd; xrpJ0: G3ivX: goto cWsXO; jZ78e: if ($img) { goto qKfLt; } goto chL0M; TFbmA: if (!pdo_update("\155\141\x6b\x65\137\163\x70\145\145\x64\137\157\x72\x64\x65\x72", array("\163\164\x61\164\165\163" => 5), array("\151\144" => $id))) { goto QYoPR; } goto t4bD8; iIS9V: if (empty($up)) { goto mJ4WD; } goto H0kCM; cWsXO: update_eleme_order($id, "\x44\x45\114\111\x56\105\122\x59\137\x43\x4f\x4d\x50\114\x45\124\105", $rider_id); goto HGtlQ; cLY5w: $expect_timed = get_mapapi_time($rider["\154\x6e\x67"] . "\54" . $rider["\x6c\x61\164"], $end["\145\156\144\137\154\x6e\147"] . "\54" . $end["\x65\156\x64\x5f\x6c\141\164"]); goto q41nM; qmfQw: QYoPR: goto Mz9Rl; XZDUz: $result = riderGotoOrder($id, intval($rider_id)); goto i_WOl; i_WOl: goto G3ivX; goto xXmWF; s32dj: $receive = isset($switchImg["\x72\x65\x63\x65\151\166\145\137\x70\x68\157\x74\157"]) ? $switchImg["\x72\x65\143\x65\151\166\x65\137\160\150\157\164\157"] : 0; goto yra1E; G_dgj: if ($order["\164\x79\x70\145"] == 5 && $order["\x70\x61\x79\x6d\x65\x6e\164"] == 3) { goto ip3Rz; } goto m_LW5; lvTbQ: if ($order["\164\171\160\x65"] == 3 && $order["\143\x68\x61\x72\x67\137\x74\171\x70\145"] == 2) { goto DgsP8; } goto TFbmA; SNG9G: return $this->result(0, "\xe7\274\xba\345\xb0\221\345\217\x82\xe6\x95\xb0\164\x79\x70\145"); goto Aey3T; BC5aV: $switch = !empty($switch) ? @array_column($switch, "\166\141\154\165\x65", "\153\145\171") : array(); goto BioYU; VQnKT: $id = !empty($_GPC["\151\144"]) ? (int) $_GPC["\151\x64"] : 0; goto a6pCn; WoMnd: $order = pdo_get("\155\x61\153\145\x5f\x73\160\145\145\x64\137\157\x72\x64\145\162", array("\151\x64" => $id), array("\x6f\x72\x64\x65\x72\x5f\x63\x6f\144\x65", "\x75\163\x65\162\137\151\144", "\160\141\171\x6d\145\x6e\x74", "\147\x6f\157\x64\163\156\141\155\x65", "\164\x79\160\x65", "\163\x74\x61\x74\165\x73", "\147\x65\164\137\x74\151\x6d\x65", "\x63\150\141\x72\147\x5f\x74\171\160\x65")); goto YC8Qe; yIxZk: zloNW: goto IJBzC; H1g_9: y5OLf: goto vWLH2; H0kCM: update_eleme_order($id, "\104\x45\x4c\x49\x56\x45\x52\x59\x5f\123\x54\x41\122\x54", $rider_id); goto ZEt2d; j8gvB: $upData = ["\160\x69\143\153\137\151\x6d\x67" => $img, "\x67\x65\164\x5f\x74\x69\155\x65" => time(), "\x67\145\164\x5f\x6d\163\145\x63\x5f\164\x69\155\x65" => msecTime(), "\x65\170\x70\x65\143\164\x5f\164\151\155\145\x64" => $expect_timed]; goto DRTj0; fvJbI: try { $redis = new Redis(); $redis->connect("\61\62\67\x2e\60\x2e\x30\56\x31", "\x36\x33\67\71"); } catch (Exception $e) { return $this->result(0, $e->getMessage()); } goto W5pWh; XYMRc: qKfLt: goto H1g_9; rNoNq: return $this->result(0, "\350\257\267\xe8\xbe\223\345\x85\xa5\xe6\255\243\347\241\256\347\x9a\x84\346\x94\xb6\344\273\266\347\240\201\357\xbc\201"); goto ZFKBb; Hlj_z: RMYIM: goto jIdU8; u_s4M: return $this->result(0, "\350\xaf\xb7\344\270\x8a\xe4\274\240\xe7\205\xa7\347\x89\207\357\274\201"); goto I3ddX; kvBTl: knDJP: goto wqBoZ; RsfYg: rider_complete_order($rider_id); goto D15Oa; iYsBv: goto aTIXT; goto XkeKy; kNDR_: gZGWT: goto ltH_o; v0dKd: return $this->result(0, "\xe8\xae\242\345\x8d\225\346\x9b\264\346\x96\260\xe5\xa4\xb1\xe8\xb4\245\xef\274\x81");