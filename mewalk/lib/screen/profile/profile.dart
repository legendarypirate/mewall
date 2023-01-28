import 'dart:math';

import 'package:flutter/cupertino.dart';
import 'package:mewalk/network/api.dart';
import 'package:flutter/material.dart';
// import 'package:buuhia/mainscreen.dart';
import 'package:mewalk/screen/auto/auto.dart';

import 'package:shared_preferences/shared_preferences.dart';

class Profile extends StatefulWidget {
  // LoginScreen({Key? key}) : super(key: key);

  @override
  State<Profile> createState() => _ProfileState();
}

class _ProfileState extends State<Profile> {
  bool _passwordVisible = false;

  @override
  void initState() {
    _passwordVisible = false;
  }

  bool _switchValue = true;
  bool _switchValue1 = true;

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
                Container(
                  margin: EdgeInsets.only(left: 20, top: 70),
                  child: Row(
                    children: <Widget>[
                      Text(
                        'Миний профайл',
                        style: TextStyle(
                            fontSize: 20, fontWeight: FontWeight.bold),
                      ),
                    ],
                  ),
                ),
                SizedBox(
                  height: 40,
                ),
                Container(
                  margin: EdgeInsets.only(left: 20),
                  child: Row(
                    children: [
                      Image.asset(
                        'assets/user.png',
                        width: 25,
                      ),
                      Container(
                        margin: EdgeInsets.only(left: 13),
                        child: Text(
                          'Хувийн мэдээлэл',
                          style: TextStyle(fontSize: 18),
                        ),
                      )
                    ],
                  ),
                ),
                SizedBox(
                  height: 40,
                ),
                Container(
                  margin: EdgeInsets.only(left: 20),
                  child: Row(
                    children: [
                      Image.asset(
                        'assets/wall.png',
                        width: 25,
                      ),
                      Container(
                        margin: EdgeInsets.only(left: 13),
                        child: Text(
                          'Дансны мэдээлэл',
                          style: TextStyle(fontSize: 18),
                        ),
                      )
                    ],
                  ),
                ),
                SizedBox(
                  height: 40,
                ),
                InkWell(
                  onTap: () {
                    Navigator.push(context,
                        new MaterialPageRoute(builder: (context) => Auto()));
                  },
                  child: Container(
                    margin: EdgeInsets.only(left: 15),
                    child: Row(
                      children: [
                        Image.asset(
                          'assets/auto.png',
                          width: 40,
                        ),
                        Expanded(
                          child: Text(
                            ' Авто wall тохиргоо',
                            style: TextStyle(fontSize: 18),
                          ),
                        ),
                        Container(
                          margin: EdgeInsets.only(right: 10),
                          child: CupertinoSwitch(
                            value: _switchValue1,
                            onChanged: (value) {
                              setState(() {
                                _switchValue1 = value;
                              });
                            },
                          ),
                        )
                      ],
                    ),
                  ),
                ),
                SizedBox(
                  height: 40,
                ),
                Container(
                  margin: EdgeInsets.only(left: 20),
                  child: Row(
                    children: [
                      Image.asset(
                        'assets/cat.png',
                        width: 30,
                      ),
                      Container(
                        margin: EdgeInsets.only(left: 8),
                        child: Text(
                          'Миний ангилал',
                          style: TextStyle(fontSize: 18),
                        ),
                      )
                    ],
                  ),
                ),
                SizedBox(
                  height: 40,
                ),
                Container(
                  margin: EdgeInsets.only(left: 15),
                  child: Row(
                    children: [
                      Image.asset(
                        'assets/bell.png',
                        width: 40,
                      ),
                      Expanded(
                        child: Text(
                          ' Мэдэгдлийн тохиргоо',
                          style: TextStyle(fontSize: 18),
                        ),
                      ),
                      Container(
                        margin: EdgeInsets.only(right: 10),
                        child: CupertinoSwitch(
                          value: _switchValue1,
                          onChanged: (value) {
                            setState(() {
                              _switchValue1 = value;
                            });
                          },
                        ),
                      )
                    ],
                  ),
                ),
                SizedBox(
                  height: 40,
                ),
                Container(
                  margin: EdgeInsets.only(left: 20),
                  child: Row(
                    children: [
                      Image.asset(
                        'assets/ii.png',
                        width: 25,
                      ),
                      Container(
                        margin: EdgeInsets.only(left: 8),
                        child: Text(
                          ' Үйлчилгээний нөхцөл',
                          style: TextStyle(fontSize: 18),
                        ),
                      )
                    ],
                  ),
                ),
                SizedBox(
                  height: 40,
                ),
                Container(
                  margin: EdgeInsets.only(left: 20),
                  child: Row(
                    children: [
                      Image.asset(
                        'assets/pho.png',
                        width: 30,
                      ),
                      Container(
                        margin: EdgeInsets.only(left: 8),
                        child: Text(
                          'Утсаар ярих',
                          style: TextStyle(fontSize: 18),
                        ),
                      )
                    ],
                  ),
                ),
                SizedBox(
                  height: 40,
                ),
                Container(
                  margin: EdgeInsets.only(left: 20),
                  child: Row(
                    children: [
                      Image.asset(
                        'assets/log.png',
                        width: 30,
                      ),
                      Text(
                        ' Гарах',
                        style: TextStyle(fontSize: 20, color: Colors.red),
                      )
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
