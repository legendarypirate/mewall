import 'dart:math';

import 'package:mewalk/network/api.dart';
import 'package:flutter/material.dart';
// import 'package:buuhia/mainscreen.dart';
import 'package:mewalk/screen/register/password.dart';

import 'package:shared_preferences/shared_preferences.dart';

class Homefirst extends StatefulWidget {
  // LoginScreen({Key? key}) : super(key: key);

  @override
  State<Homefirst> createState() => _HomefirstState();
}

class _HomefirstState extends State<Homefirst> {
  bool _passwordVisible = false;

  @override
  void initState() {
    _passwordVisible = false;
  }

  int _selectedIndex = 0;
  static const TextStyle optionStyle =
      TextStyle(fontSize: 30, fontWeight: FontWeight.bold);
  static const List<Widget> _widgetOptions = <Widget>[
    Text(
      'Index 0: Home',
      style: optionStyle,
    ),
    Text(
      'Index 1: Business',
      style: optionStyle,
    ),
    Text(
      'Index 2: School',
      style: optionStyle,
    ),
    Text(
      'Index 3: Settings',
      style: optionStyle,
    ),
  ];

  void _onItemTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
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
                      BoxShadow(color: Colors.grey, spreadRadius: 1),
                    ],
                  ),
                  child: Row(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          SizedBox(
                            height: 5,
                          ),
                          Expanded(
                              child: Container(
                            margin: EdgeInsets.only(left: 19),
                            width: totalWidth * 0.9,
                            child: Text(
                                'Та Wallpaper Автоматаар солих тохироог асааснаар сар бүр пассив орлого олох боломжтой.'),
                          )),
                          Padding(
                            padding: EdgeInsets.only(
                                left: totalWidth * 0.02, bottom: 5),
                            child: SizedBox(
                              height: 50,
                              width: totalWidth * 0.9,
                              child: TextButton(
                                  onPressed: () async {},
                                  style: TextButton.styleFrom(
                                    backgroundColor: Colors.blue,
                                    primary: Colors.white,
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(5.0),
                                    ),
                                  ),
                                  child: Text('Идэвхижүүлэх')),
                            ),
                          ),
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
                  height: totalHeight * 0.14,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(10),
                    color: Colors.white,
                    boxShadow: [
                      BoxShadow(color: Colors.grey, spreadRadius: 1),
                    ],
                  ),
                  child: Row(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          SizedBox(
                            height: 5,
                          ),
                          Expanded(
                              child: Container(
                            margin: EdgeInsets.only(left: 19),
                            width: totalWidth * 0.9,
                            child: Text(
                                'Та Wallpaper Автоматаар солих тохироог асааснаар сар бүр сугалааны тохиролд автоматаар оролцоно.'),
                          )),
                          Padding(
                            padding: EdgeInsets.only(
                                left: totalWidth * 0.02, bottom: 5),
                            child: SizedBox(
                              height: 50,
                              width: totalWidth * 0.9,
                              child: TextButton(
                                  onPressed: () async {},
                                  style: TextButton.styleFrom(
                                    backgroundColor: Colors.blue,
                                    primary: Colors.white,
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(5.0),
                                    ),
                                  ),
                                  child: Text('Идэвхижүүлэх')),
                            ),
                          ),
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
