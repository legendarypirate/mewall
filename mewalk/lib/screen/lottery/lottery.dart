import 'dart:math';

import 'package:mewalk/network/api.dart';
import 'package:flutter/material.dart';
// import 'package:buuhia/mainscreen.dart';
import 'package:mewalk/screen/register/password.dart';

import 'package:shared_preferences/shared_preferences.dart';

class Lottery extends StatefulWidget {
  // LoginScreen({Key? key}) : super(key: key);

  @override
  State<Lottery> createState() => _LotteryState();
}

class _LotteryState extends State<Lottery> {
  bool _passwordVisible = false;

  @override
  void initState() {
    _passwordVisible = false;
  }

  @override
  Widget build(BuildContext context) {
    double totalHeight = MediaQuery.of(context).size.height;
    double totalWidth = MediaQuery.of(context).size.width;
    return Scaffold(
      resizeToAvoidBottomInset: false,
      backgroundColor: Colors.white,
      body: _getBody(),
    );
  }

  TextEditingController passcont = TextEditingController();
  TextEditingController namecont = TextEditingController();
  final _formKey = GlobalKey<FormState>();

  Widget _getBody() {
    double totalHeight = MediaQuery.of(context).size.height;
    double totalWidth = MediaQuery.of(context).size.width;
    bool checkedBox = false;
    return Form(
      key: _formKey,
      child: Stack(
        children: <Widget>[
          SingleChildScrollView(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: <Widget>[
                Stack(
                  children: <Widget>[
                    Container(
                      width: totalWidth,
                      height: 240,
                      child: Image.asset(
                        'assets/backg.png',
                      ),
                    ),
                    Container(
                      margin: EdgeInsets.only(left: 10, top: 50, right: 10),
                      child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: <Widget>[
                            Text(
                              'Сугалаа',
                              style: TextStyle(
                                  color: Colors.white,
                                  fontSize: 30,
                                  fontWeight: FontWeight.bold),
                            ),
                            SizedBox(height: 10),
                            Container(
                                height: 100,
                                decoration: new BoxDecoration(
                                    color: Colors.black26,
                                    borderRadius: new BorderRadius.all(
                                      Radius.circular(10.0),
                                    )),
                                child: Container(
                                  margin: EdgeInsets.all(10),
                                  child: Text(
                                    'Та 6-р сард 3 өдөр Mewall апп-н авто тохиргоог асааж 3 сугалаатай болсон байна.',
                                    style: TextStyle(
                                        color: Colors.white, fontSize: 18),
                                  ),
                                ))
                          ]),
                    ),
                  ],
                ),
                SizedBox(
                  height: 10,
                ),
                Container(
                  margin: EdgeInsets.only(left: 10, right: 10),
                  height: totalHeight * 0.14,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(10),
                    color: Colors.white,
                    boxShadow: [
                      BoxShadow(color: Color(0xFFe1e4e8), spreadRadius: 1),
                    ],
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Row(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Expanded(
                            child: Container(
                              margin: EdgeInsets.only(left: 5, top: 5),
                              child: Text(
                                '1 өдөр = 1 сугалаа',
                                style: TextStyle(
                                    fontWeight: FontWeight.bold, fontSize: 20),
                              ),
                            ),
                          ),
                          Container(
                            margin: EdgeInsets.only(right: 10),
                            child: Image.asset(
                              'assets/ii.png',
                              width: 30,
                            ),
                          )
                        ],
                      ),
                      Container(
                        margin: EdgeInsets.all(5),
                        child: Text(
                            'Та Mewall апп-н авто солигдох тохиргоог асаасан 1 өдөр тутам 1 сугалаатай болох бөгөөд энэхүү сугалаагаар сар бүрийн хонжворт та автоматаар оролцох юм.'),
                      ),
                    ],
                  ),
                ),
                Container(
                  margin: EdgeInsets.only(left: 20, top: 10),
                  child: Row(
                    children: <Widget>[
                      Text(
                        '6 сарын хонжворууд',
                        style: TextStyle(
                            fontSize: 20, fontWeight: FontWeight.bold),
                      ),
                    ],
                  ),
                ),
                SizedBox(
                  height: 10,
                ),
                Container(
                    margin: EdgeInsets.only(left: 10, right: 10),
                    height: totalHeight * 0.23,
                    width: totalWidth * 0.95,
                    decoration: BoxDecoration(
                      borderRadius: BorderRadius.circular(10),
                      gradient: LinearGradient(
                          colors: [
                            const Color(0xFF0A99F0),
                            const Color(0xFF023C92),
                          ],
                          begin: const FractionalOffset(0.0, 0.0),
                          end: const FractionalOffset(1.0, 0.0),
                          stops: [0.0, 1.0],
                          tileMode: TileMode.clamp),
                    ),
                    child: Column(
                      children: [
                        Row(
                          children: [
                            Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Container(
                                  margin: EdgeInsets.only(left: 20),
                                  child: Text(
                                    'Энэ сарын супер хонжвор',
                                    style: TextStyle(color: Colors.white),
                                  ),
                                ),
                                Container(
                                  margin: EdgeInsets.only(left: 20),
                                  child: Text(
                                    'Iphone 13',
                                    style: TextStyle(
                                        fontSize: 30,
                                        color: Colors.white,
                                        fontWeight: FontWeight.bold),
                                  ),
                                ),
                                Container(
                                  margin: EdgeInsets.only(left: 20),
                                  child: Row(
                                    children: [
                                      Image.asset(
                                        'assets/person.png',
                                        width: 30,
                                      ),
                                      Text(
                                        '1 азтан',
                                        style: TextStyle(
                                            color: Colors.white, fontSize: 20),
                                      )
                                    ],
                                  ),
                                ),
                              ],
                            ),
                            Expanded(
                              child: Align(
                                alignment: Alignment.bottomRight,
                                child: new Image.asset(
                                  'assets/iphone.png',
                                  width: 110,
                                ),
                              ),
                            )
                          ],
                        ),
                      ],
                    )),
                SizedBox(
                  height: 10,
                ),
                Container(
                    margin: EdgeInsets.only(left: 10, right: 10),
                    height: totalHeight * 0.2,
                    width: totalWidth * 0.95,
                    decoration: BoxDecoration(
                      borderRadius: BorderRadius.circular(10),
                      gradient: LinearGradient(
                          colors: [
                            const Color(0xFF0A99F0),
                            const Color(0xFF023C92),
                          ],
                          begin: const FractionalOffset(0.0, 0.0),
                          end: const FractionalOffset(1.0, 0.0),
                          stops: [0.0, 1.0],
                          tileMode: TileMode.clamp),
                    ),
                    child: Column(
                      children: [
                        Row(
                          children: [
                            Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Container(
                                  margin: EdgeInsets.only(left: 20),
                                  child: Text(
                                    '1,000,000₮',
                                    style: TextStyle(
                                        fontSize: 30,
                                        color: Colors.white,
                                        fontWeight: FontWeight.bold),
                                  ),
                                ),
                                Container(
                                  margin: EdgeInsets.only(left: 20),
                                  child: Row(
                                    children: [
                                      Image.asset(
                                        'assets/person.png',
                                        width: 30,
                                      ),
                                      Text(
                                        '100 азтан',
                                        style: TextStyle(
                                            color: Colors.white, fontSize: 20),
                                      )
                                    ],
                                  ),
                                ),
                              ],
                            ),
                            Expanded(
                              child: Align(
                                  alignment: Alignment.bottomRight,
                                  child: Container(
                                    margin: EdgeInsets.only(right: 20, top: 20),
                                    child: new Image.asset(
                                      'assets/tug.png',
                                      width: 80,
                                    ),
                                  )),
                            )
                          ],
                        ),
                      ],
                    )),
                SizedBox(
                  height: 10,
                ),
                Container(
                    margin: EdgeInsets.only(left: 10, right: 10),
                    height: totalHeight * 0.2,
                    width: totalWidth * 0.95,
                    decoration: BoxDecoration(
                      borderRadius: BorderRadius.circular(10),
                      gradient: LinearGradient(
                          colors: [
                            const Color(0xFF0A99F0),
                            const Color(0xFF023C92),
                          ],
                          begin: const FractionalOffset(0.0, 0.0),
                          end: const FractionalOffset(1.0, 0.0),
                          stops: [0.0, 1.0],
                          tileMode: TileMode.clamp),
                    ),
                    child: Column(
                      children: [
                        Row(
                          children: [
                            Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Container(
                                  margin: EdgeInsets.only(left: 20),
                                  child: Text(
                                    '100,000₮',
                                    style: TextStyle(
                                        fontSize: 30,
                                        color: Colors.white,
                                        fontWeight: FontWeight.bold),
                                  ),
                                ),
                                Container(
                                  margin: EdgeInsets.only(left: 20),
                                  child: Row(
                                    children: [
                                      Image.asset(
                                        'assets/person.png',
                                        width: 30,
                                      ),
                                      Text(
                                        '1000 азтан',
                                        style: TextStyle(
                                            color: Colors.white, fontSize: 20),
                                      )
                                    ],
                                  ),
                                ),
                              ],
                            ),
                            Expanded(
                              child: Align(
                                  alignment: Alignment.bottomRight,
                                  child: Container(
                                    margin: EdgeInsets.only(right: 20, top: 20),
                                    child: new Image.asset(
                                      'assets/tug.png',
                                      width: 80,
                                    ),
                                  )),
                            )
                          ],
                        ),
                      ],
                    )),
                Container(
                  margin: EdgeInsets.only(left: 20, top: 10),
                  child: Row(
                    children: <Widget>[
                      Text(
                        'Азтан шалгаруулах өдөр',
                        style: TextStyle(
                            fontSize: 20, fontWeight: FontWeight.bold),
                      ),
                    ],
                  ),
                ),
                Container(
                    width: totalWidth * 0.92,
                    decoration: new BoxDecoration(
                        color: Color(0xFFf0f5f1),
                        borderRadius: new BorderRadius.all(
                          Radius.circular(10.0),
                        )),
                    margin: EdgeInsets.only(left: 15, top: 10),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Container(
                          margin: EdgeInsets.all(20),
                          child: Expanded(
                            child: Text('Тохирол'),
                          ),
                        ),
                        Container(
                          margin: EdgeInsets.only(left: 20),
                          child: Text(
                            '2022.06.24 17:00 цагт',
                            style: TextStyle(fontWeight: FontWeight.bold),
                          ),
                        ),
                        Container(
                          margin: EdgeInsets.only(left: 10, right: 10, top: 10),
                          height: 1,
                          decoration: new BoxDecoration(
                            color: Color(0xFFe1e4e8),
                          ),
                        ),
                        Container(
                          margin: EdgeInsets.all(20),
                          child: Expanded(
                            child: Text('Хаана'),
                          ),
                        ),
                        Container(
                          margin: EdgeInsets.only(left: 20, bottom: 20),
                          child: Text(
                            'Mewall Facebook хуудсаар лайв-р шалгаруулна',
                            style: TextStyle(fontWeight: FontWeight.bold),
                          ),
                        ),
                      ],
                    )),
                Container(
                  margin: EdgeInsets.only(left: 20, top: 10),
                  child: Row(
                    children: <Widget>[
                      Text(
                        'Миний сугалааны дугаар',
                        style: TextStyle(
                            fontSize: 20, fontWeight: FontWeight.bold),
                      ),
                    ],
                  ),
                ),
                Container(
                    margin: EdgeInsets.only(top: 20, left: 20, right: 20),
                    child: Column(
                      children: [
                        Row(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            SizedBox(
                              height: 5,
                            ),
                            Expanded(
                              child: Text(
                                '2022.05.22',
                              ),
                            ),
                            Text('8677030201')
                          ],
                        ),
                        Container(
                          margin: EdgeInsets.only(left: 0, right: 0, top: 10),
                          height: 1,
                          decoration: new BoxDecoration(
                            color: Colors.grey,
                          ),
                        ),
                      ],
                    )),
                Container(
                    margin: EdgeInsets.only(top: 20, left: 20, right: 20),
                    child: Column(
                      children: [
                        Row(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            SizedBox(
                              height: 5,
                            ),
                            Expanded(
                              child: Text(
                                '2022.05.22',
                              ),
                            ),
                            Text('8677030201')
                          ],
                        ),
                        Container(
                          margin: EdgeInsets.only(left: 0, right: 0, top: 10),
                          height: 1,
                          decoration: new BoxDecoration(
                            color: Colors.grey,
                          ),
                        ),
                      ],
                    )),
                Container(
                    margin: EdgeInsets.only(top: 20, left: 20, right: 20),
                    child: Column(
                      children: [
                        Row(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            SizedBox(
                              height: 5,
                            ),
                            Expanded(
                              child: Text(
                                '2022.05.22',
                              ),
                            ),
                            Text('8677030201')
                          ],
                        ),
                        Container(
                          margin: EdgeInsets.only(left: 0, right: 0, top: 10),
                          height: 1,
                          decoration: new BoxDecoration(
                            color: Colors.grey,
                          ),
                        ),
                      ],
                    )),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
