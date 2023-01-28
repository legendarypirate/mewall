import 'package:flutter/material.dart';
import 'package:mewalk/screen/onboarding.dart';
import 'package:mewalk/screen/signin.dart';
import 'package:mewalk/screen/login/login.dart';

void main() => runApp(MyApp());

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        primarySwatch: Colors.deepOrange,
      ),
      home: Login(),
    );
  }
}
