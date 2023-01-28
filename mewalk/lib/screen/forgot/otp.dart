import 'dart:convert';
import 'package:mewalk/network/api.dart';
import 'package:flutter/material.dart';
import 'package:mewalk/screen/forgot/recover.dart';

import 'package:shared_preferences/shared_preferences.dart';
import 'package:flutter_otp_text_field/flutter_otp_text_field.dart';
import 'package:otp_text_field/otp_field.dart';
import 'package:otp_text_field/otp_text_field.dart';
import 'package:otp_text_field/style.dart';

class Otp extends StatefulWidget {
  // String phone = "";
  // Otp(this.phone);
  @override
  _OtpState createState() => _OtpState();
}

class _OtpState extends State<Otp> {
  String otp = '';

  @override
  Widget build(BuildContext context) {
    double totalHeight = MediaQuery.of(context).size.height;
    double totalWidth = MediaQuery.of(context).size.width;
    return Scaffold(
      appBar: AppBar(
        titleSpacing: 0.0,
        backgroundColor: Colors.white,
        leading: IconButton(
          icon: Icon(Icons.arrow_back, color: Colors.white),
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
                  'Баталгаажуулах',
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
    return Stack(children: <Widget>[
      Column(
        children: [
          Padding(
            padding: EdgeInsets.only(
                left: totalWidth * 0.02, top: totalHeight * 0.0),
            child: Container(
              // color: Color.fromARGB(50, 200, 50, 20),
              child: Column(
                children: <Widget>[],
              ),
            ),
          ),
          Padding(
            padding: EdgeInsets.only(
                left: totalWidth * 0.01, top: totalHeight * 0.0),
            child: Container(
              // color: Color.fromARGB(50, 200, 50, 20),
              child: Column(
                children: <Widget>[
                  Padding(
                    padding: EdgeInsets.only(
                        left: totalWidth * 0.07,
                        top: totalHeight * 0.1,
                        right: 0.1),
                    child: Text(
                      'Таны bayka@yahoo.com мэйл хаягт илгээгдсэн нууц үгийг оруулна уу',
                      style: TextStyle(
                        color: Colors.black,
                        fontSize: 18,
                        decorationStyle: TextDecorationStyle.wavy,
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),
          Padding(
            padding: EdgeInsets.only(
                left: totalWidth * 0.15,
                top: totalHeight * 0.08,
                right: totalWidth * 0.15),
            child: OTPTextField(
              length: 4,
              width: MediaQuery.of(context).size.width,
              fieldWidth: 50,
              fieldStyle: FieldStyle.box,
              style: TextStyle(fontSize: 17),
              textFieldAlignment: MainAxisAlignment.spaceAround,
              onCompleted: (pin) {
                setState(() {
                  otp = pin;
                });
                print("Completed: " + pin);
              },
            ),
          ),
        ],
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
                  Navigator.push(context,
                      new MaterialPageRoute(builder: (context) => Recover()));
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
    ]);
  }
}
