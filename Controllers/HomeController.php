<?php
namespace Controllers;

use Baum\Node;
use Illuminate\Database\Eloquent\Collection;
use Monolog\Logger;
use Weile\District;
use Weile\Member;
use Weile\OrderedTreeDistrict;
use Weile\Repositories\Eloquent\MemberRepository;
use GuzzleHttp\Client;

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{

#        $list = \WeChatClient::getFollowersList();
#        foreach ($list['list'] as $item) {
#            \WeChatClient::sendTextMsg($item, 'sss');
#        }
#        var_dump($list);


#        $node = District::find(1)->children();
##        var_dump($node->get()->toArray());


#        $node = District::select('name')->getParent(533);
#        $node = District::find(37)->getParentNode();
#        $node = OrderedTreeDistrict::find(533)->ancestors()->get();
#        $node = OrderedTreeDistrict::find(1)->getDescendants();
#        $node = OrderedTreeDistrict::find(1)->getImmediateDescendants();

#        $m = app('Weile\Repositories\Eloquent\MemberRepository');
/*
        //获取某一ID的上级元素
        $res = $m->getAncestors(12,4);
        $res = array_reverse($res);
        var_dump($res);
        $root = head($res);
        var_dump($root);
        //说明已经到代理商了，需要按代理商的比例分利
        $percent_row = \ProfitPercent::first();
        $profit = 88.88;
        $profit_split = bcmul($profit, percent_div($percent_row->base), 2);
#        $profit_split = $profit*($percent_row->base/100);
        echo $profit_split;
        if($root['type'] > 0 && $root['type'] != 4) {
            echo '省市代理';
            foreach ($res as $v) {
                $percent = 0;
                switch ($v['type']) {
                    //省级代理
                    case 1:
                        $percent = $percent_row->province;
                        break;
                    //市级代理
                    case 2:
                        $percent = $percent_row->city;
                        break;
                    //门店代理
                    case 3:
                        $percent = $percent_row->store;
                        break;
                    //普通用户
                    default:
                        $percent = $percent_row->member;
                        break;
                }
                //比率X利润加到用户余额里
                $percent = percent_div($percent);
                echo bcmul($profit_split, $percent, 2);
                echo $percent,'--', $v['id'], '--',$v['type'],'<br/>';
            }
        } elseif($root['type'] == 4) { //公司代理
            echo '公司代理';
            $left = array_slice($res, 1);
            $percent = 0;
            $percent = $percent_row->member;
            //公司比例为基础比例-余下用户数分成比率
            $company_percent = $percent_row->base - (count($left)*$percent);
            echo $company_percent, '--',$root['id'], '--',$root['type'],'<br/>';
#            var_dump($company_percent);

            foreach($left as $v) {
                //添加分利

                echo $percent, '--',$v['id'], '--',$v['type'],'<br/>';
            }

        } else { //普通用户，则按用户比例分利，且只分两级
            echo '普通用户';
            $valid_user = array_slice($res,-2);
            $percent = 0;
            $percent = $percent_row->member;
            foreach($valid_user as $v) {
                //添加分利

                echo $percent, '--',$v['id'], '--',$v['type'],'<br/>';
            }
        }
*/
#        var_dump($m->addProfit(13, 88.888));
#        \DB::table('members')->update(['income_yesterday'=>0]);
#        var_dump($valid_user);

        //获取某一ID的好友
#        $res = $m->getDescendants(1);
#        var_dump($res->toArray());

#        echo 11;exit;
#        $member = Member::find(1);
#        var_dump($member->toArray());
#        $member = $member->reverseFriends()->get();
#        return $member;
#        $member = $member->Friends()->get();
#        var_dump($member->toArray());
#        var_dump($member->toArray());
#        $invite_member = $m->findByPhone('18002590105');
#        $member->addFriend($invite_member);
#        phpinfo();
#        var_dump(count($node));
#        var_dump($node->toArray());

#        $coordToGeohash = \Geotools::coordinate(['22.5195530000','114.0715420000']);

// encoding
#        $encoded = \Geotools::geohash()->encode($coordToGeohash, 6); // 12 is the default length / precision
// encoded
#        printf("%s\n", $encoded->getGeohash()); // spey
#        $member = $m->findById(11)->paylogs()->get();
#        var_dump($member->toArray());

#        $order = \CardOrder::create(['order_id'=>123, 'amount'=>12.33]);
#        $order->cardstoreds()->attach([1]);
#        $order = \CardOrder::find(1);
#        var_dump($order->cardstoreds->toArray());

#        $m = \CardStored::find(1);
#        $m = \CardOrder::find(1);
#        var_dump($m->orders);


        var_dump(\DB::getQueryLog());
#		return 'hello';
	}

    public function test() {
        return ['test', 'a'];
    }




}
