import 'dart:math';

// import 'package:bogdzonhov/mainscreen.dart';
// import 'package:bogdzonhov/network/api.dart';
import 'package:flutter/material.dart';
import 'package:mewalk/screen/auto/second.dart';

class Auto extends StatefulWidget {
  // LoginScreen({Key? key}) : super(key: key);

  @override
  State<Auto> createState() => _AutoState();
}

class _AutoState extends State<Auto> {
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
                  'assets/clap.png',
                ),
              ),
              Container(
                  margin:
                      EdgeInsets.only(left: 20, right: 20, top: 20, bottom: 20),
                  child: Center(
                    child: Text(
                      'Mywall-д тавтай\n морил Төрмөнх',
                      style:
                          TextStyle(fontSize: 25, fontWeight: FontWeight.bold),
                    ),
                  )),
              Container(
                  margin: EdgeInsets.only(left: 30, right: 20, bottom: 20),
                  child: Center(
                    child: Text(
                      'Өдөр бүр шинэ мэдээлэл & пассив орлого олох аяллаа өнөөдрөөс  эхлүүлцгээе',
                      style: TextStyle(
                        fontSize: 15,
                      ),
                    ),
                  )),
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
                                  builder: (context) => Second()));
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
