import 'dart:math';

import 'package:mewalk/network/api.dart';
import 'package:flutter/material.dart';
import 'package:mewalk/screen/forgot/otp.dart';
// import 'package:buuhia/screen/mainforavdag.dart';

import 'package:shared_preferences/shared_preferences.dart';

class Forgot extends StatefulWidget {
  // LoginScreen({Key? key}) : super(key: key);

  @override
  State<Forgot> createState() => _ForgotState();
}

class _ForgotState extends State<Forgot> {
  bool _passwordVisible = false;

  @override
  void initState() {
    _passwordVisible = false;
  }

  @override
  Widget build(BuildContext context) {
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
        child: Stack(children: <Widget>[
          Column(children: <Widget>[
            SizedBox(
              height: 70,
            ),
            Container(
              margin: EdgeInsets.only(left: 20),
              child: Text(
                'Нууц үг сэргээх',
                style: TextStyle(fontSize: 30, fontWeight: FontWeight.bold),
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
                          hintText: 'Нэвтрэх нэр',
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
                          'Имэйл/Утасны дугаар',
                          style: TextStyle(color: Colors.black, fontSize: 12),
                        ),
                      )),
                ],
              ),
            ),
          ]),
          Positioned(
            bottom: 40.0,
            left: 20,
            child: MaterialButton(
                shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.all(Radius.circular(8.0))),
                elevation: 5.0,
                minWidth: 350,
                height: 50.0,
                color: Colors.blue,
                child: Text(
                  'Үргэлжлүүлэх',
                  style: TextStyle(color: Colors.white),
                ),
                onPressed: () {
                  Navigator.push(context,
                      new MaterialPageRoute(builder: (context) => Otp()));
                }),
          )
        ]));
  }
}
