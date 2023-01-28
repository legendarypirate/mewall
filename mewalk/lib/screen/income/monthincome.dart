import 'dart:math';

import 'package:mewalk/network/api.dart';
import 'package:flutter/material.dart';
// import 'package:buuhia/mainscreen.dart';
import 'package:mewalk/screen/register/password.dart';

import 'package:shared_preferences/shared_preferences.dart';

class Income extends StatefulWidget {
  // LoginScreen({Key? key}) : super(key: key);

  @override
  State<Income> createState() => _IncomeState();
}

class _IncomeState extends State<Income> {
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
                icon: Image.asset('assets/bell.png'),
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
                  margin: EdgeInsets.only(left: 20, top: 10),
                  child: Row(
                    children: <Widget>[
                      Text(
                        'Орлого',
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
                        'Орлогын түүх',
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
                  margin: EdgeInsets.only(left: 10, right: 10, top: 10),
                  height: totalHeight * 0.08,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(5),
                    color: Colors.white54,
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
                          'assets/graph.png',
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
                            child: Text(
                              '2022.10.30',
                              style: TextStyle(fontSize: 17),
                            ),
                          ),
                          Expanded(
                              child: Row(
                            children: [
                              Image.asset(
                                'assets/icc.png',
                                width: 20,
                              ),
                              Text(
                                '10,000₮',
                                style: TextStyle(
                                    fontWeight: FontWeight.bold, fontSize: 15),
                              ),
                              Container(
                                margin: EdgeInsets.only(left: 70),
                                child: Image.asset(
                                  'assets/clock.png',
                                  width: 20,
                                ),
                              ),
                              Text(
                                ' 30 өдөр',
                                style: TextStyle(
                                    fontWeight: FontWeight.bold, fontSize: 15),
                              )
                            ],
                          )),
                        ],
                      ),
                    ],
                  ),
                ),
                SizedBox(
                  height: 10,
                ),
                Container(
                  margin: EdgeInsets.only(left: 10, right: 10, top: 10),
                  height: totalHeight * 0.08,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(5),
                    color: Colors.white54,
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
                          'assets/graph.png',
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
                            child: Text(
                              '2022.10.30',
                              style: TextStyle(fontSize: 17),
                            ),
                          ),
                          Expanded(
                              child: Row(
                            children: [
                              Image.asset(
                                'assets/icc.png',
                                width: 20,
                              ),
                              Text(
                                '10,000₮',
                                style: TextStyle(
                                    fontWeight: FontWeight.bold, fontSize: 15),
                              ),
                              Container(
                                margin: EdgeInsets.only(left: 70),
                                child: Image.asset(
                                  'assets/clock.png',
                                  width: 20,
                                ),
                              ),
                              Text(
                                ' 30 өдөр',
                                style: TextStyle(
                                    fontWeight: FontWeight.bold, fontSize: 15),
                              )
                            ],
                          )),
                        ],
                      ),
                    ],
                  ),
                ),
                SizedBox(
                  height: 10,
                ),
                Container(
                  margin: EdgeInsets.only(left: 10, right: 10, top: 10),
                  height: totalHeight * 0.08,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(5),
                    color: Colors.white54,
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
                          'assets/graph.png',
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
                            child: Text(
                              '2022.10.30',
                              style: TextStyle(fontSize: 17),
                            ),
                          ),
                          Expanded(
                              child: Row(
                            children: [
                              Image.asset(
                                'assets/icc.png',
                                width: 20,
                              ),
                              Text(
                                '10,000₮',
                                style: TextStyle(
                                    fontWeight: FontWeight.bold, fontSize: 15),
                              ),
                              Container(
                                margin: EdgeInsets.only(left: 70),
                                child: Image.asset(
                                  'assets/clock.png',
                                  width: 20,
                                ),
                              ),
                              Text(
                                ' 30 өдөр',
                                style: TextStyle(
                                    fontWeight: FontWeight.bold, fontSize: 15),
                              )
                            ],
                          )),
                        ],
                      ),
                    ],
                  ),
                ),
                SizedBox(
                  height: 10,
                ),
                Container(
                  margin: EdgeInsets.only(left: 10, right: 10, top: 10),
                  height: totalHeight * 0.08,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(5),
                    color: Colors.white54,
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
                          'assets/graph.png',
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
                            child: Text(
                              '2022.10.30',
                              style: TextStyle(fontSize: 17),
                            ),
                          ),
                          Expanded(
                              child: Row(
                            children: [
                              Image.asset(
                                'assets/icc.png',
                                width: 20,
                              ),
                              Text(
                                '10,000₮',
                                style: TextStyle(
                                    fontWeight: FontWeight.bold, fontSize: 15),
                              ),
                              Container(
                                margin: EdgeInsets.only(left: 70),
                                child: Image.asset(
                                  'assets/clock.png',
                                  width: 20,
                                ),
                              ),
                              Text(
                                ' 30 өдөр',
                                style: TextStyle(
                                    fontWeight: FontWeight.bold, fontSize: 15),
                              )
                            ],
                          )),
                        ],
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
