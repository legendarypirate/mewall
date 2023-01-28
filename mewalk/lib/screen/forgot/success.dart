import 'dart:math';

// import 'package:bogdzonhov/mainscreen.dart';
// import 'package:bogdzonhov/network/api.dart';
import 'package:flutter/material.dart';
import 'package:mewalk/screen/login/login.dart';
// import 'package:ipay/screen/register.dart';

class Success extends StatefulWidget {
  // LoginScreen({Key? key}) : super(key: key);

  @override
  State<Success> createState() => _SuccessState();
}

class _SuccessState extends State<Success> {
  bool _passwordVisible = false;
  TextEditingController namecont = TextEditingController();
  bool _checkBox = false;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        titleSpacing: 0.0,
        backgroundColor: Colors.white,
        bottomOpacity: 0.0,
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

  final _formKey = GlobalKey<FormState>();

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
                width: 50,
                height: 50,
                margin: EdgeInsets.only(left: 20, right: 20, top: 60),
                child: Image.asset(
                  'assets/succ.png',
                ),
              ),
              Padding(
                padding: EdgeInsets.only(
                    left: totalWidth * 0.2, top: totalHeight * 0.03),
                child: Container(
                  height: 170,
                  width: totalWidth - 50,
                  child: Container(
                    margin: EdgeInsets.only(left: 20, right: 20, top: 10),
                    child: Text(
                      'Нууц үг амжилттай сэргэлээ',
                      style:
                          TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                    ),
                  ),
                ),
              ),
              Positioned(
                bottom: MediaQuery.of(context).viewInsets.bottom,
                left: 30,
                right: 30,
                child: Padding(
                  padding: EdgeInsets.only(
                      left: totalWidth * 0.02, bottom: totalHeight * 0.1),
                  child: SizedBox(
                    height: 50,
                    width: totalWidth * 0.8,
                    child: TextButton(
                        onPressed: () {
                          Navigator.push(
                              context,
                              new MaterialPageRoute(
                                  builder: (context) => Login()));
                          // Map<String, dynamic> data = {
                          //   "passcode": otp,
                          //   // "phone_number": widget.phone
                          // };

                          // Network().checkData2(data, "/passcode").then((value) {
                          //   print(value);
                          //   if (value) {
                          //
                          //   } else {
                          //     ScaffoldMessenger.of(context).showSnackBar(
                          //         SnackBar(content: Text('OTP Incorrect')));
                          //   }
                          // });
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
