import 'dart:convert';

import 'package:flutter/material.dart';

import 'package:shared_preferences/shared_preferences.dart';
import 'package:flutter_otp_text_field/flutter_otp_text_field.dart';
import 'package:otp_text_field/otp_field.dart';
import 'package:otp_text_field/otp_text_field.dart';
import 'package:otp_text_field/style.dart';
// import 'package:ipay/screen/tc.dart';
import 'package:mewalk/network/api.dart';
import 'package:mewalk/screen/forgot/success.dart';

class Recover extends StatefulWidget {
  // String phone = "";
  // Recover(this.phone);
  @override
  _RecoverState createState() => _RecoverState();
}

class _RecoverState extends State<Recover> {
  bool _passwordVisible = false;
  bool _passwordVisible2 = false;

  @override
  void initState() {
    _passwordVisible = false;
    _passwordVisible2 = false;
  }

  final _formKey = GlobalKey<FormState>();
  TextEditingController pass = TextEditingController();
  TextEditingController pass1 = TextEditingController();
  @override
  Widget build(BuildContext context) {
    double totalHeight = MediaQuery.of(context).size.height;
    double totalWidth = MediaQuery.of(context).size.width;
    return Scaffold(
      appBar: AppBar(
        titleSpacing: 0.0,
        backgroundColor: Colors.white,
        leading: IconButton(
          icon: Icon(Icons.arrow_back, color: Colors.black),
          onPressed: () => Navigator.of(context).pop(),
        ),
        bottomOpacity: 0.0,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.vertical(
            bottom: Radius.circular(13),
          ),
        ),
        elevation: 0.0,
        title: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: <Widget>[
            Stack(
              alignment: Alignment.center,
              children: <Widget>[
                Text(
                  'Нууц үг сэргээх',
                  style: TextStyle(color: Colors.black),
                )
              ],
            ),
          ],
        ),
        automaticallyImplyLeading: false,
        centerTitle: true,
        actions: <Widget>[
          SizedBox(
            width: 30,
          )
        ],
      ),
      resizeToAvoidBottomInset: false,
      backgroundColor: Colors.white,
      body: _getBody(),
    );
  }

  Widget _getBody() {
    double totalHeight = MediaQuery.of(context).size.height;
    double totalWidth = MediaQuery.of(context).size.width;
    bool checkedBox = false;
    return Form(
        key: _formKey,
        child: Stack(children: <Widget>[
          Column(
            children: <Widget>[
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
                          validator: (value) {
                            if (value == null || value.isEmpty) {
                              return 'Please enter some text';
                            }
                            return null;
                          },
                          obscureText: !_passwordVisible,
                          controller: pass,
                          keyboardType: TextInputType.text,
                          decoration: InputDecoration(
                            errorStyle: TextStyle(color: Colors.white),
                            suffixIcon: IconButton(
                              icon: Icon(
                                // Based on passwordVisible state choose the icon
                                _passwordVisible
                                    ? Icons.visibility
                                    : Icons.visibility_off,
                                color: Theme.of(context).primaryColorDark,
                              ),
                              onPressed: () {
                                // Update the state i.e. toogle the state of passwordVisible variable
                                setState(() {
                                  _passwordVisible = !_passwordVisible;
                                });
                              },
                            ),
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
                            'Нууц үг',
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
                          validator: (value) {
                            if (value == null || value.isEmpty) {
                              return 'Please enter some text';
                            }
                            return null;
                          },
                          obscureText: !_passwordVisible,
                          controller: pass1,
                          keyboardType: TextInputType.text,
                          decoration: InputDecoration(
                            errorStyle: TextStyle(color: Colors.white),
                            suffixIcon: IconButton(
                              icon: Icon(
                                // Based on passwordVisible state choose the icon
                                _passwordVisible
                                    ? Icons.visibility
                                    : Icons.visibility_off,
                                color: Theme.of(context).primaryColorDark,
                              ),
                              onPressed: () {
                                // Update the state i.e. toogle the state of passwordVisible variable
                                setState(() {
                                  _passwordVisible = !_passwordVisible;
                                });
                              },
                            ),
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
                            'Нууц үг давтах',
                            style: TextStyle(color: Colors.black, fontSize: 12),
                          ),
                        )),
                  ],
                ),
              ),
              Container(
                width: totalWidth * 0.9,
                child: Padding(
                  padding: EdgeInsets.only(
                      left: totalWidth * 0.0, bottom: totalHeight * 0.1),
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
                          //     // Navigator.push(
                          //     //     context,
                          //     //     new MaterialPageRoute(
                          //     //         builder: (context) => Tc()));
                          //   }
                          // } else {
                          //   ScaffoldMessenger.of(context).showSnackBar(
                          //       SnackBar(content: Text('Password Not Match')));
                          // }
                          Navigator.push(
                              context,
                              new MaterialPageRoute(
                                  builder: (context) => Success()));
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
            ],
          ),
        ]));
  }
}
