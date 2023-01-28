import 'dart:math';

import 'package:mewalk/network/api.dart';
import 'package:flutter/material.dart';
// import 'package:buuhia/mainscreen.dart';
import 'package:mewalk/screen/register/password.dart';

import 'package:shared_preferences/shared_preferences.dart';

class Account extends StatefulWidget {
  // LoginScreen({Key? key}) : super(key: key);

  @override
  State<Account> createState() => _AccountState();
}

class _AccountState extends State<Account> {
  bool _passwordVisible = false;

  @override
  void initState() {
    _passwordVisible = false;
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        titleSpacing: 0.0,
        backgroundColor: Colors.white,
        bottomOpacity: 0.0,
        leading: IconButton(
          icon: Icon(Icons.arrow_back, color: Colors.black),
          onPressed: () => Navigator.of(context).pop(),
        ),
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.vertical(
            bottom: Radius.circular(13),
          ),
        ),
        elevation: 0.0,
        automaticallyImplyLeading: false,
        centerTitle: true,
        actions: <Widget>[
          Row(
            children: <Widget>[],
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
  TextEditingController dscont = TextEditingController();
  TextEditingController sdcont = TextEditingController();
  final _formKey = GlobalKey<FormState>();

  Widget _getBody() {
    double totalHeight = MediaQuery.of(context).size.height;
    double totalWidth = MediaQuery.of(context).size.width;
    bool checkedBox = false;
    return Form(
        key: _formKey,
        child: Stack(children: <Widget>[
          Column(crossAxisAlignment: CrossAxisAlignment.start, children: <
              Widget>[
            Container(
              margin: EdgeInsets.only(left: 20),
              child: Text(
                'Бүртгүүлэх 2/3',
                style: TextStyle(fontSize: 25, fontWeight: FontWeight.bold),
              ),
            ),
            Container(
              child: Stack(
                children: <Widget>[
                  Container(
                    width: double.infinity,
                    height: 50,
                    margin: EdgeInsets.fromLTRB(20, 20, 20, 10),
                    padding: EdgeInsets.only(bottom: 10),
                    decoration: BoxDecoration(
                      border: Border.all(color: Colors.grey, width: 1),
                      borderRadius: BorderRadius.circular(5),
                      shape: BoxShape.rectangle,
                    ),
                    child: SizedBox(
                      height: 100,
                      width: totalWidth * 0.8,
                      child: TextFormField(
                        controller: namecont,
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Please enter some text';
                          }
                          return null;
                        },
                        keyboardType: TextInputType.text,
                        decoration: InputDecoration(
                          errorStyle: TextStyle(color: Colors.white),
                          hintStyle: TextStyle(color: Colors.white),
                          filled: true,
                          fillColor: Color(0xFFF8FAFB),
                          enabledBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(15),
                              borderSide: BorderSide(color: Colors.white)),
                          focusedBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(15),
                              borderSide: BorderSide(color: Colors.white)),
                        ),
                        cursorColor: Colors.grey,
                      ),
                    ),
                  ),
                  Positioned(
                      left: 50,
                      top: 12,
                      child: Container(
                        padding:
                            EdgeInsets.only(bottom: 10, left: 10, right: 10),
                        color: Colors.white,
                        child: Text(
                          'Орлого хүлээн авах банк сонгох',
                          style: TextStyle(color: Colors.black, fontSize: 12),
                        ),
                      )),
                ],
              ),
            ),
            Container(
              child: Stack(
                children: <Widget>[
                  Container(
                    width: double.infinity,
                    height: 50,
                    margin: EdgeInsets.fromLTRB(20, 20, 20, 10),
                    padding: EdgeInsets.only(bottom: 10),
                    decoration: BoxDecoration(
                      border: Border.all(color: Colors.grey, width: 1),
                      borderRadius: BorderRadius.circular(5),
                      shape: BoxShape.rectangle,
                    ),
                    child: SizedBox(
                      height: 100,
                      width: totalWidth * 0.8,
                      child: TextFormField(
                        controller: passcont,
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Please enter some text';
                          }
                          return null;
                        },
                        keyboardType: TextInputType.text,
                        decoration: InputDecoration(
                          errorStyle: TextStyle(color: Colors.white),
                          hintStyle: TextStyle(color: Colors.white),
                          filled: true,
                          fillColor: Color(0xFFF8FAFB),
                          enabledBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(15),
                              borderSide: BorderSide(color: Colors.white)),
                          focusedBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(15),
                              borderSide: BorderSide(color: Colors.white)),
                        ),
                        cursorColor: Colors.grey,
                      ),
                    ),
                  ),
                  Positioned(
                      left: 50,
                      top: 12,
                      child: Container(
                        padding:
                            EdgeInsets.only(bottom: 10, left: 10, right: 10),
                        color: Colors.white,
                        child: Text(
                          'Дансны дугаар бичих',
                          style: TextStyle(color: Colors.black, fontSize: 12),
                        ),
                      )),
                ],
              ),
            ),
            Container(
              child: Stack(
                children: <Widget>[
                  Container(
                    width: double.infinity,
                    height: 50,
                    margin: EdgeInsets.fromLTRB(20, 20, 20, 10),
                    padding: EdgeInsets.only(bottom: 10),
                    decoration: BoxDecoration(
                      border: Border.all(color: Colors.grey, width: 1),
                      borderRadius: BorderRadius.circular(5),
                      shape: BoxShape.rectangle,
                    ),
                    child: SizedBox(
                      height: 100,
                      width: totalWidth * 0.8,
                      child: TextFormField(
                        controller: dscont,
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Please enter some text';
                          }
                          return null;
                        },
                        keyboardType: TextInputType.text,
                        decoration: InputDecoration(
                          errorStyle: TextStyle(color: Colors.white),
                          hintStyle: TextStyle(color: Colors.white),
                          filled: true,
                          fillColor: Color(0xFFF8FAFB),
                          enabledBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(15),
                              borderSide: BorderSide(color: Colors.white)),
                          focusedBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(15),
                              borderSide: BorderSide(color: Colors.white)),
                        ),
                        cursorColor: Colors.grey,
                      ),
                    ),
                  ),
                  Positioned(
                      left: 50,
                      top: 12,
                      child: Container(
                        padding:
                            EdgeInsets.only(bottom: 10, left: 10, right: 10),
                        color: Colors.white,
                        child: Text(
                          'Таны нас',
                          style: TextStyle(color: Colors.black, fontSize: 12),
                        ),
                      )),
                ],
              ),
            ),
            Container(
              child: Stack(
                children: <Widget>[
                  Container(
                    width: double.infinity,
                    height: 50,
                    margin: EdgeInsets.fromLTRB(20, 20, 20, 10),
                    padding: EdgeInsets.only(bottom: 10),
                    decoration: BoxDecoration(
                      border: Border.all(color: Colors.grey, width: 1),
                      borderRadius: BorderRadius.circular(5),
                      shape: BoxShape.rectangle,
                    ),
                    child: SizedBox(
                      height: 100,
                      width: totalWidth * 0.8,
                      child: TextFormField(
                        controller: sdcont,
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Please enter some text';
                          }
                          return null;
                        },
                        keyboardType: TextInputType.text,
                        decoration: InputDecoration(
                          errorStyle: TextStyle(color: Colors.white),
                          hintStyle: TextStyle(color: Colors.white),
                          filled: true,
                          fillColor: Color(0xFFF8FAFB),
                          enabledBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(15),
                              borderSide: BorderSide(color: Colors.white)),
                          focusedBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(15),
                              borderSide: BorderSide(color: Colors.white)),
                        ),
                        cursorColor: Colors.grey,
                      ),
                    ),
                  ),
                  Positioned(
                      left: 50,
                      top: 12,
                      child: Container(
                        padding:
                            EdgeInsets.only(bottom: 10, left: 10, right: 10),
                        color: Colors.white,
                        child: Text(
                          'Таны хүйс',
                          style: TextStyle(color: Colors.black, fontSize: 12),
                        ),
                      )),
                ],
              ),
            ),
            Container(
              width: totalWidth * 0.95,
              child: Padding(
                padding: EdgeInsets.only(
                    left: totalWidth * 0.05, bottom: totalHeight * 0.02),
                child: SizedBox(
                  height: 50,
                  width: totalWidth * 0.8,
                  child: TextButton(
                      onPressed: () {
                        // if (_formKey.currentState!.validate()) {
                        //   bool tt = pass.text == pass1.text;
                        //   print(tt);
                        //   if (tt) {
                        //     Map<String, dynamic> data = {
                        //       "password": pass.text,
                        //       // "phone": widget.phone
                        //     };
                        //
                        //     Network().checkData2(data, "/createpass");
                        //
                        Navigator.push(
                            context,
                            new MaterialPageRoute(
                                builder: (context) => Password()));
                        //   }
                        // } else {
                        //   ScaffoldMessenger.of(context).showSnackBar(
                        //       SnackBar(content: Text('Password Not Match')));
                        // }
                        // Navigator.push(
                        //     context,
                        //     new MaterialPageRoute(
                        //         builder: (context) => Success()));
                      },
                      style: TextButton.styleFrom(
                        backgroundColor: Colors.blue,
                        primary: Colors.white,
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(15.0),
                        ),
                      ),
                      child: Text('ҮРГЭЛЖЛҮҮЛЭХ')),
                ),
              ),
            ),
            Container(
                margin: EdgeInsets.only(left: 100),
                child: Row(
                  children: [
                    Text('Та бүртгэлтэй юу?'),
                    Container(
                        margin: EdgeInsets.only(left: 10),
                        child: InkWell(
                          onTap: () {
                            Navigator.push(
                                context,
                                new MaterialPageRoute(
                                    builder: (context) => Password()));
                          },
                          child: Text(
                            'Нэвтрэх',
                            style: TextStyle(
                              decoration: TextDecoration.underline,
                            ),
                          ),
                        ))
                  ],
                )),
          ]),
        ]));
  }
}
