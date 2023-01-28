import 'dart:math';

import 'package:mewalk/network/api.dart';
import 'package:flutter/material.dart';
// import 'package:buuhia/mainscreen.dart';
import 'package:mewalk/screen/register/password.dart';

import 'package:shared_preferences/shared_preferences.dart';

class Home extends StatefulWidget {
  // LoginScreen({Key? key}) : super(key: key);

  @override
  State<Home> createState() => _HomeState();
}

class _HomeState extends State<Home> {
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
      appBar: AppBar(
        titleSpacing: 0.0,
        backgroundColor: Colors.transparent,
        bottomOpacity: 0.0,
        elevation: 0.0,
        title: Row(
          mainAxisAlignment: MainAxisAlignment.start,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: <Widget>[
            Stack(
              alignment: Alignment.center,
              children: <Widget>[
                Padding(
                  padding: EdgeInsets.only(left: totalWidth * 0.05),
                  child: Image.asset(
                    'assets/img.png',
                    height: 200,
                    width: 100,
                  ),
                ),
              ],
            ),
          ],
        ),
        automaticallyImplyLeading: false,
        centerTitle: true,
        actions: <Widget>[
          Row(
            children: <Widget>[
              IconButton(
                icon: Image.asset(
                  'assets/bell.png',
                ),
                onPressed: () {},
              ),
            ],
          )
        ],
      ),
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
                Container(
                  margin: EdgeInsets.only(left: 0),
                  child: Image.asset('assets/back.png'),
                ),
                Container(
                  margin: EdgeInsets.only(left: 20, top: 10),
                  child: Row(
                    children: <Widget>[
                      Text(
                        'Бүх WallPaper',
                        style: TextStyle(
                            fontSize: 20, fontWeight: FontWeight.bold),
                      ),
                      Expanded(
                        child: Align(
                          alignment: Alignment.bottomRight,
                          child: new Container(
                            width: 30,
                            margin: EdgeInsets.only(right: 20),
                            child: Image.asset('assets/arr.png'),
                          ),
                        ),
                      )
                    ],
                  ),
                ),
                Container(
                  child: SingleChildScrollView(
                      scrollDirection: Axis.horizontal,
                      child: Row(
                        children: [
                          Container(
                              height: totalHeight * 0.3,
                              margin: EdgeInsets.fromLTRB(20, 20, 0, 10),
                              padding: EdgeInsets.only(bottom: 10),
                              child: Image.asset('assets/wp.png')),
                          Container(
                              height: totalHeight * 0.3,
                              margin: EdgeInsets.fromLTRB(20, 20, 0, 10),
                              padding: EdgeInsets.only(bottom: 10),
                              child: Image.asset('assets/wp.png')),
                          Container(
                              height: totalHeight * 0.3,
                              margin: EdgeInsets.fromLTRB(20, 20, 0, 10),
                              padding: EdgeInsets.only(bottom: 10),
                              child: Image.asset('assets/wp.png')),
                        ],
                      )),
                ),
                Container(
                  margin: EdgeInsets.only(left: 20, top: 10),
                  child: Row(
                    children: <Widget>[
                      Text(
                        '6 сарын орлого',
                        style: TextStyle(
                            fontSize: 20, fontWeight: FontWeight.bold),
                      ),
                      Expanded(
                        child: Align(
                          alignment: Alignment.bottomRight,
                          child: new Container(
                            width: 30,
                            margin: EdgeInsets.only(right: 20),
                            child: Image.asset('assets/arr.png'),
                          ),
                        ),
                      )
                    ],
                  ),
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
                  child: Row(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Container(
                        margin: EdgeInsets.only(
                            left: 5, top: 5, bottom: 5, right: 5),
                        child: Image.asset(
                          'assets/eyes.png',
                          width: 40,
                        ),
                      ),
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          SizedBox(
                            height: 5,
                          ),
                          Expanded(
                            child: Text('Таны энэ сарын орлого ойролцоогоор'),
                          ),
                          Expanded(
                            child: Text(
                              '5000₮-10000₮',
                              style: TextStyle(
                                  color: Colors.blue,
                                  fontSize: 20,
                                  fontWeight: FontWeight.bold),
                            ),
                          ),
                          Container(
                            height: 1,
                            width: totalWidth * 0.7,
                            color: Colors.grey,
                          ),
                          Row(
                            children: [
                              Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Container(
                                    margin: EdgeInsets.only(
                                        left: 0, top: 5, bottom: 0),
                                    child: Text('Шилжүүлэх огноо'),
                                  ),
                                  Container(
                                    margin: EdgeInsets.only(
                                        left: 0, top: 5, bottom: 5),
                                    child: Text(
                                      '2022.06.11',
                                      style: TextStyle(
                                          fontWeight: FontWeight.bold),
                                    ),
                                  ),
                                ],
                              ),
                              Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Container(
                                    margin: EdgeInsets.only(
                                      left: 30,
                                      top: 5,
                                    ),
                                    child: Text('Ашигласан өдөр'),
                                  ),
                                  Container(
                                    margin: EdgeInsets.only(
                                        left: 30, top: 5, bottom: 5),
                                    child: Text(
                                      '17',
                                      style: TextStyle(
                                          fontWeight: FontWeight.bold),
                                    ),
                                  ),
                                ],
                              )
                            ],
                          )
                        ],
                      ),
                    ],
                  ),
                ),
                Container(
                  margin: EdgeInsets.only(left: 20, top: 10),
                  child: Row(
                    children: <Widget>[
                      Text(
                        '6 сарын сугалаа',
                        style: TextStyle(
                            fontSize: 20, fontWeight: FontWeight.bold),
                      ),
                      Expanded(
                        child: Align(
                          alignment: Alignment.bottomRight,
                          child: new Container(
                            width: 30,
                            margin: EdgeInsets.only(right: 20),
                            child: Image.asset('assets/arr.png'),
                          ),
                        ),
                      )
                    ],
                  ),
                ),
                SizedBox(
                  height: 10,
                ),
                Container(
                    margin: EdgeInsets.only(left: 10, right: 10),
                    height: totalHeight * 0.3,
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
                        Container(
                          margin: EdgeInsets.only(top: totalHeight * 0.00095),
                          height: totalWidth * 0.25,
                          decoration: BoxDecoration(
                              borderRadius: BorderRadius.circular(10),
                              color: Colors.white),
                          child: Column(
                            children: [
                              Row(
                                children: [
                                  Container(
                                    margin: EdgeInsets.only(left: 10, top: 14),
                                    child: Text('Азтан шалгаруулах'),
                                  ),
                                  Expanded(
                                    child: Align(
                                      alignment: Alignment.topRight,
                                      child: new Container(
                                        margin:
                                            EdgeInsets.only(top: 18, right: 10),
                                        child: Text('2022.11.30'),
                                      ),
                                    ),
                                  )
                                ],
                              ),
                              Row(
                                children: List.generate(
                                    240 ~/ 10,
                                    (index) => Expanded(
                                          child: Container(
                                            margin: EdgeInsets.only(top: 10),
                                            color: index % 2 == 0
                                                ? Colors.transparent
                                                : Colors.grey,
                                            height: 1,
                                          ),
                                        )),
                              ),
                              Row(
                                children: [
                                  Container(
                                    margin: EdgeInsets.only(left: 10, top: 14),
                                    child: Text('Сугалааны эрх'),
                                  ),
                                  Expanded(
                                    child: Align(
                                      alignment: Alignment.topRight,
                                      child: new Container(
                                        margin:
                                            EdgeInsets.only(top: 18, right: 10),
                                        child: Text('17'),
                                      ),
                                    ),
                                  )
                                ],
                              ),
                            ],
                          ),
                        )
                      ],
                    ))
              ],
            ),
          ),
        ],
      ),
    );
  }
}
