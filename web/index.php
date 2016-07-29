<?php
require('../vendor/autoload.php');

use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

$app->post('/callback', function (Request $request) use ($app) {
    $client = new GuzzleHttp\Client();

    $body = json_decode($request->getContent(), true);
    foreach ($body['result'] as $msg) {
      error_log($msg['content']['text']);
        //if (!preg_match('/(ぬるぽ|ヌルポ|ﾇﾙﾎﾟ|nullpo)/i', $msg['content']['text'])) {
        //    continue;
        //}

        $resContent = $msg['content'];
        //$resContent['text'] = 'ｶﾞｯ';

        $resmsg ='';
        switch(mt_rand(1,12)){
          case 1:
            $resmsg = "一番になるっつったよな？ナンバー1になるっつったよな！？\nまずは、形から入ってみろよ！今日からお前は！！一番だ！！！";
            break;
          case 2:
            $resmsg = "諦めんなよ！諦めんなよ、お前！！";
            break;
          case 3:
            $resmsg = "何言ってんだよ！！ その崖っぷちが最高のチャンスなんだぜ！！";
            break;
          case 4:
            $resmsg = "本気になれば自分が変わる！ 本気になれば全てが変わる！！";
            break;
          case 5:
              $resmsg = "君が次に叩く１回で、壁は打ち破れるかもしれないんだ！";
              break;
          case 6:
              $resmsg = "おまえの終わり方は、なんとなくフィニッシュだ！";
              break;
          case 7:
              $resmsg = "真剣だからこそ、ぶつかる壁がある。";
              break;
          case 8:
              $resmsg = "ベストを尽くすだけでは勝てない。僕は勝ちにいく。";
              break;
          case 9:
              $resmsg = "じゃんけんの必勝法は、強く握り締めたグーを出すこと";
              break;
          case 10:
              $resmsg = "もっと熱くなれよ\n熱い血燃やしてけよ！\n人間熱くなった時が本当の自分に出会えるんだ！！\nだからこそ\nもっと熱くなれよおおおおおおおおおお！！！";
              break;
          case 11:
              $resmsg = "褒め言葉よりも苦言に感謝";
              break;
          case 12:
              $resmsg = "プレッシャーを感じられることは幸せなことだ";
              break;
          case 13:
              $resmsg = "勝ち負けなんか、ちっぽけなこと。\n大事なことは、本気だったかどうかだ！";
              break;
          case 14:
              $resmsg = "僕は忙しいと思ったことが1回もありません。たぶん、本当に忙しくないのでしょう。\n「お疲れさま」と言われても、たいていは疲れていないので、冗談を言える人には「疲れてません」といいます。";
              break;
          case 15:
              $resmsg = "やがて僕のレベルも知らず知らずに上がっていった。\nなぜなら、僕が戦う相手は、いつも自分より強かったからである。";
              break;
          case 16:
              $resmsg = "ミスをすることは悪いことじゃない。それは上達するためには必ず必要なもの。ただし、同じミスはしないこと。";
              break;
          case 17:
              $resmsg = "褒め言葉よりも苦言に感謝。";
              break;
          case 18:
              $resmsg = "苦しいか？ 修造！笑え！";
              break;
          case 19:
              $resmsg = "人の弱点を見つける天才よりも、人を褒める天才がいい。";
              break;
          case 20:
              $resmsg = "反省はしろ！後悔はするな！";
              break;
        }
        $resContent['text'] = $resmsg;
        $requestOptions = [
            'body' => json_encode([
                'to' => [$msg['content']['from']],
                'toChannel' => 000000000, # Fixed value
                'eventType' => '000000000', # Fixed value
                'content' => $resContent,
            ]),
            'headers' => [
                'Content-Type' => 'application/json; charset=UTF-8',
                'X-Line-ChannelID' => getenv('LINE_CHANNEL_ID'),
                'X-Line-ChannelSecret' => getenv('LINE_CHANNEL_SECRET'),
                'X-Line-Trusted-User-With-ACL' => getenv('LINE_CHANNEL_MID'),
            ],
            'proxy' => [
                'https' => getenv('FIXIE_URL'),
            ],
        ];

        try {
            $client->request('post', 'https://trialbot-api.line.me/v1/events', $requestOptions);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    return 'OK';
});

$app->run();
