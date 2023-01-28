import 'dart:math';

import 'package:mewalk/network/api.dart';
import 'package:flutter/material.dart';
import 'package:mewalk/screen/forgot/forgotpass.dart';
import 'package:mewalk/screen/register/register.dart';
import 'package:mewalk/screen/home/navbar.dart';
import 'package:sign_in_with_apple/sign_in_with_apple.dart';

import 'package:shared_preferences/shared_preferences.dart';

class Login extends StatefulWidget {
  // LoginScreen({Key? key}) : super(key: key);

  @override
  State<Login> createState() => _LoginState();
}

class _LoginState extends State<Login> {
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
          Column(crossAxisAlignment: CrossAxisAlignment.start, children: <
              Widget>[
            SizedBox(
              height: 180,
            ),
            Container(
              margin: EdgeInsets.only(left: 20),
              child: Text(
                'Нэвтрэх',
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
                    child: Container(
                      margin: EdgeInsets.only(top: 40),
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
                          enabledBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(15),
                              borderSide: BorderSide(color: Colors.white)),
                          focusedBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(15),
                              borderSide: BorderSide(color: Colors.white)),
                        ),
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
                    child: Container(
                      margin: EdgeInsets.only(top: 10),
                      width: totalWidth * 0.8,
                      child: TextFormField(
                        validator: (value) {},
                        obscureText: !_passwordVisible,
                        controller: passcont,
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
            Padding(
              padding: EdgeInsets.only(
                left: totalWidth * 0.5,
              ),
              child: SizedBox(
                height: 50,
                width: 200,
                child: TextButton(
                    onPressed: () {
                      Navigator.push(
                          context,
                          new MaterialPageRoute(
                              builder: (context) => Forgot()));
                    },
                    style: TextButton.styleFrom(
                      primary: Colors.black,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(15.0),
                      ),
                    ),
                    child: Text('НУУЦ ҮГ СЭРГЭЭХ')),
              ),
            ),
            Container(
              margin: EdgeInsets.only(left: 20, right: 20),
              child: Container(
                height: 50,
                width: totalWidth * 0.9,
                child: TextButton(
                    onPressed: () async {
                      Navigator.push(
                          context,
                          new MaterialPageRoute(
                              builder: (context) => Navbar()));
                    },
                    style: TextButton.styleFrom(
                      backgroundColor: Colors.blueAccent,
                      primary: Colors.white,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(5.0),
                      ),
                    ),
                    child: Text('НЭВТРЭХ')),
              ),
            ),
            Padding(
                padding: EdgeInsets.only(
                    left: totalWidth * 0.0, top: totalHeight * 0),
                child: Container(
                  margin: const EdgeInsets.all(15.0),
                  padding: const EdgeInsets.all(3.0),
                  decoration: BoxDecoration(
                    border: Border.all(color: Colors.grey),
                    borderRadius: BorderRadius.circular(10),
                  ),
                  child: SizedBox(
                    height: 50,
                    width: totalWidth * 0.9,
                    child: TextButton(
                        onPressed: () async {
                          Navigator.push(
                              context,
                              new MaterialPageRoute(
                                  builder: (context) => Register()));
                        },
                        style: TextButton.styleFrom(
                          backgroundColor: Colors.white,
                          primary: Colors.black,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(5.0),
                          ),
                        ),
                        child: Text('БҮРТГҮҮЛЭХ')),
                  ),
                )),
            Container(
              margin: const EdgeInsets.all(15.0),
              padding: const EdgeInsets.all(3.0),
              decoration: BoxDecoration(
                border: Border.all(color: Colors.white),
                borderRadius: BorderRadius.circular(10),
              ),
              child: SizedBox(
                height: 50,
                width: totalWidth * 0.9,
                child: TextButton(
                    onPressed: () async {},
                    style: TextButton.styleFrom(
                      backgroundColor: Colors.blueAccent,
                      primary: Colors.black,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(5.0),
                      ),
                    ),
                    child: Row(
                      children: [
                        Container(
                          margin: EdgeInsets.only(left: 100),
                          child: Image.asset(
                            'assets/gmail.png',
                            width: 20,
                          ),
                        ),
                        Text(
                          '  Google-ээр нэвтрэх',
                          style: TextStyle(color: Colors.white),
                        )
                      ],
                    )),
              ),
            ),
            SignInWithAppleButton(
              onPressed: () async {
                final credential = await SignInWithApple.getAppleIDCredential(
                  scopes: [
                    AppleIDAuthorizationScopes.email,
                    AppleIDAuthorizationScopes.fullName,
                  ],
                );

                print(credential);

                // Now send the credential (especially `credential.authorizationCode`) to your server to create a session
                // after they have been validated with Apple (see `Integration` section for more information on how to do this)
              },
            ),
            Container(
              margin: const EdgeInsets.all(15.0),
              padding: const EdgeInsets.all(3.0),
              decoration: BoxDecoration(
                border: Border.all(color: Colors.white),
                borderRadius: BorderRadius.circular(10),
              ),
              child: Row(children: [
                SizedBox(
                    height: 50,
                    width: totalWidth * 0.89,
                    child: TextButton(
                        onPressed: () async {},
                        style: TextButton.styleFrom(
                          backgroundColor: Colors.black,
                          primary: Colors.white,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(5.0),
                          ),
                        ),
                        child: Row(
                          children: [
                            Container(
                              margin: EdgeInsets.only(left: 100),
                              child: Image.asset(
                                'assets/apple.png',
                                width: 20,
                              ),
                            ),
                            Text(
                              '  Apple-ээр нэвтрэх',
                              style: TextStyle(color: Colors.white),
                            )
                          ],
                        )))
              ]),
            ),
          ]),
        ]));
  }
}
