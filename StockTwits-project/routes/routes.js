var st = require('stocktwits');
var json2csv = require('json2csv');







module.exports = function(app) {

/*

	app.get('/', function(req, res) {
		res.send(
        	'<form action="/upload" method="post" enctype="multipart/form-data">'+
        	'<input type="file" name="images">'+
        	'<input type="submit" value="Upload">'+
        	'</form>' );
	});

	app.get('/profilepic/:fileid', function (req,res) {
		var file = req.params.fileid;

		var conlog = 'sending ' + file;
		console.log(conlog);

		res.sendfile('./photos/thumbnails/' + file);
	});

	app.post('/login',function(req,res){
		var email = req.body.email;
        	var password = req.body.password;

		login.login(email,password,function (found) {
			console.log(found);
			res.json(found);
	});
	});

	*/


	app.get('/grabstuff', function (req,resp) {
		var responsebod = null;
		st.get('streams/user/StockTwits', function (err, res) {
			var jsondata = res.body;
			var user = jsondata['user'];
			var messages = jsondata['messages'];
			console.log(messages);
			var fs = require('fs');

			json2csv({data: messages, fields: ['created_at']}, function(err, csv) {
  				if (err) console.log(err);
  				fs.writeFile('file.csv', csv, function(err) {
    				if (err) throw err;
    				console.log('file saved');
  				});
			});
    		//console.log(res.body);
    		
    		//responsebod = res.body;
    		responsebod = messages;
    		resp.send(responsebod);
		});
	});

/*

{
   "response":{
      "status":200
   },
   "user":{
      "id":170,
      "username":"StockTwits",
      "name":"StockTwits",
      "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
      "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
      "official":true,
      "identity":"Official",
      "classification":[
         "ir",
         "suggested",
         "official"
      ],
      "join_date":"2009-08-31",
      "followers":77777,
      "following":10000,
      "ideas":47809,
      "following_stocks":81,
      "location":"New York",
      "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
      "website_url":"http://stocktwits.com",
      "trading_strategy":{
         "assets_frequently_traded":[
            "Equities",
            "Options",
            "Forex",
            "Futures",
            "Bonds",
            "Private Companies"
         ],
         "approach":null,
         "holding_period":null,
         "experience":"Novice"
      }
   },
   "cursor":{
      "more":true,
      "since":23854605,
      "max":23836798
   },
   "messages":[
      {
         "id":23854605,
         "body":"+18% now &quot;@momomiester: $ANFI smoked earnings... big gap&quot;",
         "created_at":"2014-06-17T13:43:16Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77777,
            "following":10000,
            "ideas":47809,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":11354,
               "symbol":"ANFI",
               "title":"Amira Nature Foods Ltd."
            }
         ]
      },
      {
         "id":23854410,
         "body":"&quot;@openoutcrier: $EW (+5.8% pre) FDA approval for SAPIEN XT transcatheter aortic heart valve for the treatment of aortic stenosis (AS)&quot;",
         "created_at":"2014-06-17T13:40:23Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77777,
            "following":10000,
            "ideas":47808,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":5245,
               "symbol":"EW",
               "title":"Edwards Lifesciences Corp."
            }
         ]
      },
      {
         "id":23854355,
         "body":"As @Fibline would say, &quot;KISS&quot; &quot;@greenport: $INTC lots of noise out there. http://stks.co/j0iw8&quot;",
         "created_at":"2014-06-17T13:39:29Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77777,
            "following":10000,
            "ideas":47807,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":2310,
               "symbol":"INTC",
               "title":"Intel Corporation"
            }
         ],
         "conversation":{
            "parent_message_id":23852970,
            "in_reply_to_message_id":23852970,
            "parent":false,
            "replies":1
         }
      },
      {
         "id":23854260,
         "body":"Nice look &quot;@CaptainJohn: $SPY $SPX when it gets quite here, usually time to sharpen your horns http://stks.co/e0fDy&quot;",
         "created_at":"2014-06-17T13:37:54Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77777,
            "following":10000,
            "ideas":47806,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":679,
               "symbol":"SPX",
               "title":"S&P 500 Index"
            },
            {
               "id":7271,
               "symbol":"SPY",
               "title":"SPDR S&P 500"
            }
         ],
         "conversation":{
            "parent_message_id":23848520,
            "in_reply_to_message_id":23848520,
            "parent":false,
            "replies":1
         }
      },
      {
         "id":23853362,
         "body":"@openoutcrier Whoa!",
         "created_at":"2014-06-17T13:18:41Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77777,
            "following":10000,
            "ideas":47807,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "conversation":{
            "parent_message_id":23853206,
            "in_reply_to_message_id":23853206,
            "parent":false,
            "replies":6
         }
      },
      {
         "id":23853356,
         "body":"&quot;@a_jackson: Inflation starting to trend higher.  Chart via @Econoday  $SPY http://stks.co/j0iv4&quot;",
         "created_at":"2014-06-17T13:18:28Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77777,
            "following":10000,
            "ideas":47804,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":7271,
               "symbol":"SPY",
               "title":"SPDR S&P 500"
            }
         ]
      },
      {
         "id":23853066,
         "body":"Morning earnings --&gt; &quot;@FactSet: FactSet Research Systems reports results for Q3 of Fiscal 2014 http://stks.co/j0iuj $FDS&quot;",
         "created_at":"2014-06-17T13:10:46Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77776,
            "following":10000,
            "ideas":47803,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":5320,
               "symbol":"FDS",
               "title":"FactSet Research Systems Inc."
            }
         ]
      },
      {
         "id":23853039,
         "body":"@openoutcrier @FoxBusiness @MariaBartiromo Wow!",
         "created_at":"2014-06-17T13:09:58Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77776,
            "following":10000,
            "ideas":47802,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "conversation":{
            "parent_message_id":23852996,
            "in_reply_to_message_id":23852996,
            "parent":false,
            "replies":1
         }
      },
      {
         "id":23853018,
         "body":"&quot;@Benzinga: Coca Cola Share Move Higher as Activist Investor David Winters on Fox Business Discusses Possibility of Coke Going Private $KO&quot;",
         "created_at":"2014-06-17T13:09:29Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77776,
            "following":10000,
            "ideas":47801,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":6102,
               "symbol":"KO",
               "title":"The Coca-Cola Company"
            }
         ]
      },
      {
         "id":23852709,
         "body":"Inflation watch &quot;@TradersAudio: Consumer Price Index consensus 0.2% actual 0.4% minus food/energy consensus 0.2% actual 0.3% $ES_F&quot;",
         "created_at":"2014-06-17T13:00:09Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77776,
            "following":10000,
            "ideas":47800,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":647,
               "symbol":"ES_F",
               "title":"E-Mini S&P 500 Futures"
            }
         ]
      },
      {
         "id":23852678,
         "body":"&quot;@etfdigest: $SPY $ITB Housing Starts slumped to 1.001M vs 1.036M exp &amp; prior 1.022M\nPermits 991K vs 1.062M exp &amp; prior 1.080M&quot;",
         "created_at":"2014-06-17T12:58:59Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77777,
            "following":10000,
            "ideas":47805,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":5906,
               "symbol":"ITB",
               "title":"iShares Dow Jones US Home Construction"
            },
            {
               "id":7271,
               "symbol":"SPY",
               "title":"SPDR S&P 500"
            }
         ],
         "likes":{
            "total":1,
            "user_ids":[
               63351
            ]
         }
      },
      {
         "id":23852669,
         "body":"Whoa. Eyes on this --&gt; &quot;@TopstepTrader: *EXPLOSION ON UKRAINE GAS TRANSIT PIPELINE REPORTED: IFX $SPY $EURUSD&quot;",
         "created_at":"2014-06-17T12:58:46Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77776,
            "following":10000,
            "ideas":47798,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":667,
               "symbol":"EURUSD",
               "title":"Euro / US Dollar"
            },
            {
               "id":7271,
               "symbol":"SPY",
               "title":"SPDR S&P 500"
            }
         ]
      },
      {
         "id":23852618,
         "body":"&quot;@agwarner: Taking Advantage of Low Volatility: Should you swap stock ownership with long calls? http://stks.co/i0irF $VIX&quot;",
         "created_at":"2014-06-17T12:57:07Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77776,
            "following":10000,
            "ideas":47797,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":680,
               "symbol":"VIX",
               "title":"CBOE Volatility Index"
            }
         ]
      },
      {
         "id":23852535,
         "body":"@iamnotaweed @8675309 We do not support OTC and Pink Sheet stocks right now. If CEY is on the TSX we can add it.",
         "created_at":"2014-06-17T12:54:05Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77776,
            "following":10000,
            "ideas":47800,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "conversation":{
            "parent_message_id":23797499,
            "in_reply_to_message_id":23844338,
            "parent":false,
            "replies":12
         }
      },
      {
         "id":23852479,
         "body":"Tesla Saves NY Stores, Could Push Similar Deals In Other States http://stks.co/b0f8p $TSLA",
         "created_at":"2014-06-17T12:51:46Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77777,
            "following":10000,
            "ideas":47803,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":8660,
               "symbol":"TSLA",
               "title":"Tesla Motors, Inc."
            }
         ],
         "likes":{
            "total":1,
            "user_ids":[
               110615
            ]
         }
      },
      {
         "id":23852268,
         "body":"&quot;@derekhernquist: one of my faves, congrats on 8 years! RT @HCPG: New post! Stock Talk http://stks.co/b0f8h  $IWM $FSLR $TSLA $GMCR $SUNE&quot;",
         "created_at":"2014-06-17T12:46:04Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77776,
            "following":10000,
            "ideas":47798,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":1949,
               "symbol":"FSLR",
               "title":"First Solar, Inc."
            },
            {
               "id":2025,
               "symbol":"GMCR",
               "title":"Green Mountain Coffee Roasters Inc."
            },
            {
               "id":5930,
               "symbol":"IWM",
               "title":"iShares Russell 2000 Index"
            },
            {
               "id":7719,
               "symbol":"SUNE",
               "title":"SunEdison Inc"
            },
            {
               "id":8660,
               "symbol":"TSLA",
               "title":"Tesla Motors, Inc."
            }
         ],
         "conversation":{
            "parent_message_id":23852268,
            "in_reply_to_message_id":null,
            "parent":true,
            "replies":1
         }
      },
      {
         "id":23852219,
         "body":"&quot;@CrosbyVenture: American Tower capitalizing on world cup traffic? Buying BR Towers for $1 bln. $AMT http://stks.co/f0j4P&quot;",
         "created_at":"2014-06-17T12:44:43Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77774,
            "following":9999,
            "ideas":47793,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":4337,
               "symbol":"AMT",
               "title":"American Tower Corp."
            }
         ]
      },
      {
         "id":23852203,
         "body":"&quot;@RedDogT3Live: $SPY levels and thoughts ahead of the Fed http://stks.co/a0f85&quot;",
         "created_at":"2014-06-17T12:44:16Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77774,
            "following":9999,
            "ideas":47792,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":7271,
               "symbol":"SPY",
               "title":"SPDR S&P 500"
            }
         ]
      },
      {
         "id":23852201,
         "body":"Big list &quot;@karleggerss: Street #upgrades: $AEM $WHZ $UNCFF $LAZ $PEG $EXC $EXPE $AWI $AINV $NFLX $LUV $SNDK $WMB $MDT&quot;",
         "created_at":"2014-06-17T12:44:10Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77774,
            "following":9999,
            "ideas":47792,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":785,
               "symbol":"AINV",
               "title":"Apollo Investment Corporation"
            },
            {
               "id":1812,
               "symbol":"EXPE",
               "title":"Expedia Inc."
            },
            {
               "id":2839,
               "symbol":"NFLX",
               "title":"Netflix, Inc."
            },
            {
               "id":3585,
               "symbol":"SNDK",
               "title":"SanDisk Corp."
            },
            {
               "id":4254,
               "symbol":"AEM",
               "title":"Agnico Eagle Mines Ltd."
            },
            {
               "id":4415,
               "symbol":"AWI",
               "title":"Armstrong World Industries, Inc."
            },
            {
               "id":5269,
               "symbol":"EXC",
               "title":"Exelon Corp."
            },
            {
               "id":6153,
               "symbol":"LAZ",
               "title":"Lazard Ltd."
            },
            {
               "id":6214,
               "symbol":"LUV",
               "title":"Southwest Airlines Co."
            },
            {
               "id":6260,
               "symbol":"MDT",
               "title":"Medtronic, Inc."
            },
            {
               "id":6717,
               "symbol":"PEG",
               "title":"Public Service Enterprise Group Inc."
            },
            {
               "id":7740,
               "symbol":"WMB",
               "title":"Williams Companies, Inc."
            },
            {
               "id":11295,
               "symbol":"WHZ",
               "title":"Whiting USA Trust II"
            }
         ]
      },
      {
         "id":23847427,
         "body":"Wells Fargo Almost Most Valuable Bank Ever http://stks.co/g0j05 via @skrisiloff $WFC $JPM $BAC",
         "created_at":"2014-06-17T02:59:58Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77758,
            "following":9999,
            "ideas":47790,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":4438,
               "symbol":"BAC",
               "title":"Bank of America Corporation"
            },
            {
               "id":6020,
               "symbol":"JPM",
               "title":"JPMorgan Chase & Co."
            },
            {
               "id":7718,
               "symbol":"WFC",
               "title":"Wells Fargo & Company"
            }
         ]
      },
      {
         "id":23847228,
         "body":"StockTwits is partnering with @DraftKings for fantasy golf. Get your entry to the $300k British Open contest here: http://stks.co/a0f1q",
         "created_at":"2014-06-17T02:42:42Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77757,
            "following":9999,
            "ideas":47789,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         }
      },
      {
         "id":23846945,
         "body":"The flight to crazy could be reaching warp speeds http://stks.co/c0f4K via @howardlindzon $VIX $SPY $FB",
         "created_at":"2014-06-17T02:21:04Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77757,
            "following":9999,
            "ideas":47789,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":680,
               "symbol":"VIX",
               "title":"CBOE Volatility Index"
            },
            {
               "id":7271,
               "symbol":"SPY",
               "title":"SPDR S&P 500"
            },
            {
               "id":7871,
               "symbol":"FB",
               "title":"Facebook"
            }
         ],
         "conversation":{
            "parent_message_id":23846945,
            "in_reply_to_message_id":null,
            "parent":true,
            "replies":0
         },
         "likes":{
            "total":1,
            "user_ids":[
               76647
            ]
         }
      },
      {
         "id":23845768,
         "body":"8 helpful tips to keep your online trading and financial data safe http://stks.co/f0ixG [sponsored]",
         "created_at":"2014-06-17T00:55:10Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77754,
            "following":9999,
            "ideas":47787,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         }
      },
      {
         "id":23840361,
         "body":"&quot;@dividenddotcom: $GM issues another massive recall. At this point the company is on pace to recall more vehicles than is produces in 2014&quot;",
         "created_at":"2014-06-16T20:43:25Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77748,
            "following":9999,
            "ideas":47786,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":9358,
               "symbol":"GM",
               "title":"General Motors Company"
            }
         ],
         "likes":{
            "total":3,
            "user_ids":[
               197734,
               7496,
               169892
            ]
         }
      },
      {
         "id":23838931,
         "body":"Big day b/c of this &quot;@Street_Insider: Nuance Communications $NUAN said to have held talks with Samsung, PE firms - DJN $$&quot;",
         "created_at":"2014-06-16T20:08:34Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77746,
            "following":9999,
            "ideas":47785,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":2917,
               "symbol":"NUAN",
               "title":"Nuance Communications, Inc."
            }
         ]
      },
      {
         "id":23838739,
         "body":"@MarketPicker nice one",
         "created_at":"2014-06-16T20:05:16Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77762,
            "following":9999,
            "ideas":47790,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "conversation":{
            "parent_message_id":23813223,
            "in_reply_to_message_id":23813223,
            "parent":false,
            "replies":1
         },
         "likes":{
            "total":1,
            "user_ids":[
               148175
            ]
         }
      },
      {
         "id":23838698,
         "body":"$TSLA had one of its biggest days of the year today. It climbed 8.81% and hit its highest level since April. Top trending ticker too.",
         "created_at":"2014-06-16T20:04:22Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77749,
            "following":9999,
            "ideas":47786,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":8660,
               "symbol":"TSLA",
               "title":"Tesla Motors, Inc."
            }
         ],
         "likes":{
            "total":3,
            "user_ids":[
               246053,
               313442,
               113191
            ]
         }
      },
      {
         "id":23837848,
         "body":"&quot;@ivanhoff: Checking back on the &quot;Elon Musk&quot; ETF. Major breakout today. $TSLA $SCTY  http://stks.co/b0euR&quot;",
         "created_at":"2014-06-16T19:50:28Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77746,
            "following":9999,
            "ideas":47785,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":8660,
               "symbol":"TSLA",
               "title":"Tesla Motors, Inc."
            },
            {
               "id":11326,
               "symbol":"SCTY",
               "title":"SolarCity"
            }
         ],
         "conversation":{
            "parent_message_id":23830633,
            "in_reply_to_message_id":23830633,
            "parent":false,
            "replies":1
         },
         "likes":{
            "total":1,
            "user_ids":[
               110615
            ]
         }
      },
      {
         "id":23837833,
         "body":"&quot;@jackdamn: $CVX putting in fresh 20-year highs today. Up about 777% since 1995.  http://stks.co/d0emt&quot;",
         "created_at":"2014-06-16T19:50:06Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77745,
            "following":9998,
            "ideas":47782,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":4874,
               "symbol":"CVX",
               "title":"Chevron Corp."
            }
         ],
         "likes":{
            "total":1,
            "user_ids":[
               36852
            ]
         }
      },
      {
         "id":23836798,
         "body":"Here’s Why Everyone Should Be Watching Small Cap Stocks Right Now http://stks.co/a0esR $IWM $RUT $VIX $VRX",
         "created_at":"2014-06-16T19:29:45Z",
         "user":{
            "id":170,
            "username":"StockTwits",
            "name":"StockTwits",
            "avatar_url":"http://avatars.stocktwits.net/production/170/thumb-1378905743.png",
            "avatar_url_ssl":"https://s3.amazonaws.com/st-avatars/production/170/thumb-1378905743.png",
            "official":true,
            "identity":"Official",
            "classification":[
               "ir",
               "suggested",
               "official"
            ],
            "join_date":"2009-08-31",
            "followers":77745,
            "following":9998,
            "ideas":47782,
            "following_stocks":81,
            "location":"New York",
            "bio":"Real-time stock conversations. Follow me and prefix tickers with $ (e.g. $GLD) to have your tweets indexed!",
            "website_url":"http://stocktwits.com",
            "trading_strategy":{
               "assets_frequently_traded":[
                  "Equities",
                  "Options",
                  "Forex",
                  "Futures",
                  "Bonds",
                  "Private Companies"
               ],
               "approach":null,
               "holding_period":null,
               "experience":"Novice"
            }
         },
         "source":{
            "id":1,
            "title":"StockTwits",
            "url":"http://stocktwits.com"
         },
         "symbols":[
            {
               "id":680,
               "symbol":"VIX",
               "title":"CBOE Volatility Index"
            },
            {
               "id":5930,
               "symbol":"IWM",
               "title":"iShares Russell 2000 Index"
            },
            {
               "id":7673,
               "symbol":"VRX",
               "title":"Valeant Pharmaceuticals International, Inc."
            },
            {
               "id":9698,
               "symbol":"RUT",
               "title":"Russell 2000 Index"
            }
         ],
         "likes":{
            "total":1,
            "user_ids":[
               142159
            ]
         }
      }
   ]
}

*/

};



