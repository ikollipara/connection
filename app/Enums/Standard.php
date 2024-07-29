<?php

namespace App\Enums;

use Closure;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self CSTA_1A_CS_01()
 * @method static self CSTA_1A_CS_02()
 * @method static self CSTA_1A_CS_03()
 * @method static self CSTA_1B_CS_01()
 * @method static self CSTA_1B_CS_02()
 * @method static self CSTA_1B_CS_03()
 * @method static self CSTA_2_CS_01()
 * @method static self CSTA_2_CS_02()
 * @method static self CSTA_2_CS_03()
 * @method static self CSTA_3A_CS_01()
 * @method static self CSTA_3A_CS_02()
 * @method static self CSTA_3A_CS_03()
 * @method static self CSTA_3B_CS_01()
 * @method static self CSTA_3B_CS_02()
 * @method static self CSTA_1A_NI_04()
 * @method static self CSTA_1B_NI_04()
 * @method static self CSTA_1B_NI_05()
 * @method static self CSTA_2_NI_04()
 * @method static self CSTA_2_NI_05()
 * @method static self CSTA_2_NI_06()
 * @method static self CSTA_3A_NI_04()
 * @method static self CSTA_3A_NI_05()
 * @method static self CSTA_3A_NI_06()
 * @method static self CSTA_3A_NI_07()
 * @method static self CSTA_3A_NI_08()
 * @method static self CSTA_3B_NI_03()
 * @method static self CSTA_3B_NI_04()
 * @method static self CSTA_1A_DA_05()
 * @method static self CSTA_1A_DA_06()
 * @method static self CSTA_1A_DA_07()
 * @method static self CSTA_1B_DA_06()
 * @method static self CSTA_1B_DA_07()
 * @method static self CSTA_2_DA_07()
 * @method static self CSTA_2_DA_08()
 * @method static self CSTA_2_DA_09()
 * @method static self CSTA_3A_DA_09()
 * @method static self CSTA_3A_DA_10()
 * @method static self CSTA_3A_DA_11()
 * @method static self CSTA_3A_DA_12()
 * @method static self CSTA_3B_DA_05()
 * @method static self CSTA_3B_DA_06()
 * @method static self CSTA_3B_DA_07()
 * @method static self CSTA_1A_AP_08()
 * @method static self CSTA_1A_AP_09()
 * @method static self CSTA_1A_AP_10()
 * @method static self CSTA_1A_AP_11()
 * @method static self CSTA_1A_AP_12()
 * @method static self CSTA_1A_AP_13()
 * @method static self CSTA_1A_AP_14()
 * @method static self CSTA_1A_AP_15()
 * @method static self CSTA_1B_AP_08()
 * @method static self CSTA_1B_AP_09()
 * @method static self CSTA_1B_AP_10()
 * @method static self CSTA_1B_AP_11()
 * @method static self CSTA_1B_AP_12()
 * @method static self CSTA_1B_AP_13()
 * @method static self CSTA_1B_AP_14()
 * @method static self CSTA_1B_AP_15()
 * @method static self CSTA_1B_AP_16()
 * @method static self CSTA_1B_AP_17()
 * @method static self CSTA_2_AP_10()
 * @method static self CSTA_2_AP_11()
 * @method static self CSTA_2_AP_12()
 * @method static self CSTA_2_AP_13()
 * @method static self CSTA_2_AP_14()
 * @method static self CSTA_2_AP_15()
 * @method static self CSTA_2_AP_16()
 * @method static self CSTA_2_AP_17()
 * @method static self CSTA_2_AP_18()
 * @method static self CSTA_2_AP_19()
 * @method static self CSTA_3A_AP_13()
 * @method static self CSTA_3A_AP_14()
 * @method static self CSTA_3A_AP_15()
 * @method static self CSTA_3A_AP_16()
 * @method static self CSTA_3A_AP_17()
 * @method static self CSTA_3A_AP_18()
 * @method static self CSTA_3A_AP_19()
 * @method static self CSTA_3A_AP_20()
 * @method static self CSTA_3A_AP_21()
 * @method static self CSTA_3A_AP_22()
 * @method static self CSTA_3A_AP_23()
 * @method static self CSTA_3B_AP_08()
 * @method static self CSTA_3B_AP_09()
 * @method static self CSTA_3B_AP_10()
 * @method static self CSTA_3B_AP_11()
 * @method static self CSTA_3B_AP_12()
 * @method static self CSTA_3B_AP_13()
 * @method static self CSTA_3B_AP_14()
 * @method static self CSTA_3B_AP_15()
 * @method static self CSTA_3B_AP_16()
 * @method static self CSTA_3B_AP_17()
 * @method static self CSTA_3B_AP_18()
 * @method static self CSTA_3B_AP_19()
 * @method static self CSTA_3B_AP_20()
 * @method static self CSTA_3B_AP_21()
 * @method static self CSTA_3B_AP_22()
 * @method static self CSTA_3B_AP_23()
 * @method static self CSTA_3B_AP_24()
 * @method static self CSTA_1A_IC_16()
 * @method static self CSTA_1A_IC_17()
 * @method static self CSTA_1A_IC_18()
 * @method static self CSTA_1B_IC_18()
 * @method static self CSTA_1B_IC_19()
 * @method static self CSTA_1B_IC_20()
 * @method static self CSTA_1B_IC_21()
 * @method static self CSTA_2_IC_20()
 * @method static self CSTA_2_IC_21()
 * @method static self CSTA_2_IC_22()
 * @method static self CSTA_2_IC_23()
 * @method static self CSTA_3A_IC_24()
 * @method static self CSTA_3A_IC_25()
 * @method static self CSTA_3A_IC_26()
 * @method static self CSTA_3A_IC_27()
 * @method static self CSTA_3A_IC_28()
 * @method static self CSTA_3A_IC_29()
 * @method static self CSTA_3A_IC_30()
 * @method static self CSTA_3B_IC_25()
 * @method static self CSTA_3B_IC_26()
 * @method static self CSTA_3B_IC_27()
 * @method static self CSTA_3B_IC_28()
 * @method static self NE_CS_HS_1_a()
 * @method static self NE_CS_HS_1_b()
 * @method static self NE_CS_HS_1_c()
 * @method static self NE_CS_HS_1_d()
 * @method static self NE_CS_HS_1_e()
 * @method static self NE_CS_HS_2_a()
 * @method static self NE_CS_HS_2_b()
 * @method static self NE_CS_HS_2_c()
 * @method static self NE_CS_HS_2_d()
 * @method static self NE_CS_HS_2_e()
 * @method static self NE_CS_HS_3_a()
 * @method static self NE_CS_HS_3_b()
 * @method static self NE_CS_HS_3_c()
 * @method static self NE_CS_HS_3_d()
 * @method static self NE_CS_HS_3_e()
 * @method static self NE_CS_HS_3_f()
 * @method static self NE_CS_HS_3_g()
 * @method static self NE_CS_HS_4_a()
 * @method static self NE_CS_HS_4_b()
 * @method static self NE_CS_HS_4_c()
 * @method static self NE_CS_HS_5_a()
 * @method static self NE_CS_HS_5_b()
 * @method static self NE_CS_HS_5_c()
 * @method static self NE_CS_HS_5_d()
 * @method static self NE_CS_HS_5_e()
 * @method static self NE_CS_HS_6_a()
 * @method static self NE_CS_HS_6_b()
 * @method static self NE_CS_HS_6_c()
 * @method static self NE_CS_HS_6_d()
 * @method static self NE_CS_HS_6_e()
 * @method static self NE_CS_HS_6_f()
 */
class Standard extends Enum
{
    public static function getGroup(StandardGroup $group)
    {
        return collect(static::toValues())
            ->filter(fn ($value) => str_starts_with($value, $group))
            ->values();
    }

    protected static function values(): Closure
    {
        return function (string $value) {
            if (str_starts_with($value, 'CSTA')) {
                return str_replace('_', '-', substr($value, 5));
            } elseif (str_starts_with($value, 'NE')) {
                return str_replace('_', '.', substr($value, 3));
            }
        };
    }

    protected static function labels()
    {
        return [
            'CSTA_1A_CS_01' => '1A-CS-01 Select and operate appropriate software to perform a variety of tasks, and recognize that
             users have different needs and preferences for the technology they use',
            'CSTA_1A_CS_02' => '1A-CS-02 Use appropriate terminology in identifying and describing the function of common physical
             components of computing systems (hardware)',
            'CSTA_1A_CS_03' => '1A-CS-03 Describe basic hardware and software problems using accurate terminology',
            'CSTA_1B_CS_01' => '1B-CS-01 Describe how internal and external parts of computing devices function to form a system',
            'CSTA_1B_CS_02' => '1B-CS-02 Model how computer hardware and software work together as a system to accomplish
             tasks',
            'CSTA_1B_CS_03' => '1B-CS-03 Determine potential solutions to solve simple hardware and software problems using
             common troubleshooting strategies',
            'CSTA_2_CS_01' => '2-CS-01 Recommend improvements to the design of computing devices, based on an analysis of
             how users interact with the devices',
            'CSTA_2_CS_02' => '2-CS-02 Design projects that combine hardware and software components to collect and exchange
             data',
            'CSTA_2_CS_03' => '2-CS-03 Systematically identify and fix problems with computing devices and their components',
            'CSTA_3A_CS_01' => '3A-CS-01 Explain how abstractions hide the underlying implementation details of computing systems
             embedded in everyday objects',
            'CSTA_3A_CS_02' => '3A-CS-02 Compare levels of abstraction and interactions between application software, system
             software, and hardware layers',
            'CSTA_3A_CS_03' => '3A-CS-03 Develop guidelines that convey systematic troubleshooting strategies that others can use to
             identify and fix errors',
            'CSTA_3B_CS_01' => '3B-CS-01 Categorize the roles of operating system software',
            'CSTA_3B_CS_02' => '3B-CS-02 Illustrate ways computing systems implement logic, input, and output through hardware
             components',
            'CSTA_1A_NI_04' => '1A-NI-04 Explain what passwords are and why we use them, and use strong passwords to protect
             devices and information from unauthorized access',
            'CSTA_1B_NI_04' => '1B-NI-04 Model how information is broken down into smaller pieces, transmitted as packets through
             multiple devices over networks and the Internet, and reassembled at the destination',
            'CSTA_1B_NI_05' => '1B-NI-05 Discuss real-world cybersecurity problems and how personal information can be protected',
            'CSTA_2_NI_04' => '2-NI-04 Model the role of protocols in transmitting data across networks and the Internet',
            'CSTA_2_NI_05' => '2-NI-05 Explain how physical and digital security measures protect electronic information',
            'CSTA_2_NI_06' => '2-NI-06 Apply multiple methods of encryption to model the secure transmission of information',
            'CSTA_3A_NI_04' => '3A-NI-04 Evaluate the scalability and reliability of networks, by describing the relationship between
             routers, switches, servers, topology, and addressing',
            'CSTA_3A_NI_05' => '3A-NI-05 Give examples to illustrate how sensitive data can be affected by malware and other
             attacks',
            'CSTA_3A_NI_06' => '3A-NI-06 Recommend security measures to address various scenarios based on factors such as
             efficiency, feasibility, and ethical impacts',
            'CSTA_3A_NI_07' => '3A-NI-07 Compare various security measures, considering tradeoffs between the usability and
             security of a computing system',
            'CSTA_3A_NI_08' => '3A-NI-08 Explain tradeoffs when selecting and implementing cybersecurity recommendations',
            'CSTA_3B_NI_03' => '3B-NI-03 Describe the issues that impact network functionality (e.g., bandwidth, load, delay,
             topology)',
            'CSTA_3B_NI_04' => '3B-NI-04 Compare ways software developers protect devices and information from unauthorized
             access',
            'CSTA_1A_DA_05' => '1A-DA-05 Store, copy, search, retrieve, modify, and delete information using a computing device and
             define the information stored as data',
            'CSTA_1A_DA_06' => '1A-DA-06 Collect and present the same data in various visual formats',
            'CSTA_1A_DA_07' => '1A-DA-07 Identify and describe patterns in data visualizations, such as charts or graphs, to make
             predictions',
            'CSTA_1B_DA_06' => '1B-DA-06 Organize and present collected data visually to highlight relationships and support a claim',
            'CSTA_1B_DA_07' => '1B-DA-07 Use data to highlight or propose cause-and-effect relationships, predict outcomes, or
             communicate an idea',
            'CSTA_2_DA_07' => '2-DA-07 Represent data using multiple encoding schemes',
            'CSTA_2_DA_08' => '2-DA-08 Collect data using computational tools and transform the data to make it more useful and
             reliable',
            'CSTA_2_DA_09' => '2-DA-09 Refine computational models based on the data they have generated',
            'CSTA_3A_DA_09' => '3A-DA-09 Translate between different bit representations of real-world phenomena, such as
             characters, numbers, and images',
            'CSTA_3A_DA_10' => '3A-DA-10 Evaluate the tradeoffs in how data elements are organized and where data is stored',
            'CSTA_3A_DA_11' => '3A-DA-11 Create interactive data visualizations using software tools to help others better understand
             real-world phenomena',
            'CSTA_3A_DA_12' => '3A-DA-12 Create computational models that represent the relationships among different elements of
             data collected from a phenomenon or process',
            'CSTA_3B_DA_05' => '3B-DA-05 Use data analysis tools and techniques to identify patterns in data representing complex
             systems',
            'CSTA_3B_DA_06' => '3B-DA-06 Select data collection tools and techniques to generate data sets that support a claim or
             communicate information',
            'CSTA_3B_DA_07' => '3B-DA-07 Evaluate the ability of models and simulations to test and support the refinement of
             hypotheses',
            'CSTA_1A_AP_08' => '1A-AP-08 Model daily processes by creating and following algorithms (sets of step-by-step
             instructions) to complete tasks',
            'CSTA_1A_AP_09' => '1A-AP-09 Model the way programs store and manipulate data by using numbers or other symbols to
             represent information',
            'CSTA_1A_AP_10' => '1A-AP-10 Develop programs with sequences and simple loops, to express ideas or address a
             problem',
            'CSTA_1A_AP_11' => '1A-AP-11 Decompose (break down) the steps needed to solve a problem into a precise sequence of
             instructions',
            'CSTA_1A_AP_12' => '1A-AP-12 Develop plans that describe a program\'s sequence of events, goals, and expected
             outcomes',
            'CSTA_1A_AP_13' => '1A-AP-13 Give attribution when using the ideas and creations of others while developing programs',
            'CSTA_1A_AP_14' => '1A-AP-14 Debug (identify and fix) errors in an algorithm or program that includes sequences and
             simple loops',
            'CSTA_1A_AP_15' => '1A-AP-15 Using correct terminology, describe steps taken and choices made during the iterative
             process of program development',
            'CSTA_1B_AP_08' => '1B-AP-08 Compare and refine multiple algorithms for the same task and determine which is the most
             appropriate',
            'CSTA_1B_AP_09' => '1B-AP-09 Create programs that use variables to store and modify data',
            'CSTA_1B_AP_10' => '1B-AP-10 Create programs that include sequences, events, loops, and conditionals',
            'CSTA_1B_AP_11' => '1B-AP-11 Decompose (break down) problems into smaller, manageable subproblems to facilitate the
             program development process',
            'CSTA_1B_AP_12' => '1B-AP-12 Modify, remix, or incorporate portions of an existing program into one\'s own work, to
             develop something new or add more advanced features',
            'CSTA_1B_AP_13' => '1B-AP-13 Use an iterative process to plan the development of a program by including others\'
             perspectives and considering user preferences',
            'CSTA_1B_AP_14' => '1B-AP-14 Observe intellectual property rights and give appropriate attribution when creating or
             remixing programs',
            'CSTA_1B_AP_15' => '1B-AP-15 Test and debug (identify and fix errors) a program or algorithm to ensure it runs as
             intended',
            'CSTA_1B_AP_16' => '1B-AP-16 Use flowcharts and/or pseudocode to address complex problems as algorithms',
            'CSTA_1B_AP_17' => '1B-AP-17 Describe choices made during program development using code comments, presentations,
             and demonstrations',
            'CSTA_2_AP_10' => '2-AP-10 Use flowcharts and/or pseudocode to address complex problems as algorithms',
            'CSTA_2_AP_11' => '2-AP-11 Create clearly named variables that represent different data types and perform operations
             on their values',
            'CSTA_2_AP_12' => '2-AP-12 Design and iteratively develop programs that combine control structures, including nested
             loops and compound conditionals',
            'CSTA_2_AP_13' => '2-AP-13 Decompose problems and subproblems into parts to facilitate the design, implementation,
             and review of programs',
            'CSTA_2_AP_14' => '2-AP-14 Create procedures with parameters to organize code and make it easier to reuse',
            'CSTA_2_AP_15' => '2-AP-15 Seek and incorporate feedback from team members and users to refine a solution that
             meets user needs',
            'CSTA_2_AP_16' => '2-AP-16 Incorporate existing code, media, and libraries into original programs, and give attribution',
            'CSTA_2_AP_17' => '2-AP-17 Systematically test and refine programs using a range of test cases',
            'CSTA_2_AP_18' => '2-AP-18 Distribute tasks and maintain a project timeline when collaboratively developing
             computational artifacts',
            'CSTA_2_AP_19' => '2-AP-19 Document programs in order to make them easier to follow, test, and debug',
            'CSTA_3A_AP_13' => '3A-AP-13 Create prototypes that use algorithms to solve computational problems by leveraging prior
             student knowledge and personal interests',
            'CSTA_3A_AP_14' => '3A-AP-14 Use lists to simplify solutions, generalizing computational problems instead of repeatedly
             using simple variables',
            'CSTA_3A_AP_15' => '3A-AP-15 Justify the selection of specific control structures when tradeoffs involve implementation,
             readability, and program performance, and explain the benefits and drawbacks of choices
             made',
            'CSTA_3A_AP_16' => '3A-AP-16 Design and iteratively develop computational artifacts for practical intent, personal
             expression, or to address a societal issue by using events to initiate instructions',
            'CSTA_3A_AP_17' => '3A-AP-17 Decompose problems into smaller components through systematic analysis, using
             constructs such as procedures, modules, and/or objects',
            'CSTA_3A_AP_18' => '3A-AP-18 Create artifacts by using procedures within a program, combinations of data and
             procedures, or independent but interrelated programs',
            'CSTA_3A_AP_19' => '3A-AP-19 Systematically design and develop programs for broad audiences by incorporating
             feedback from users',
            'CSTA_3A_AP_20' => '3A-AP-20 Evaluate licenses that limit or restrict use of computational artifacts when using resources
             such as libraries',
            'CSTA_3A_AP_21' => '3A-AP-21 Evaluate and refine computational artifacts to make them more usable and accessible',
            'CSTA_3A_AP_22' => '3A-AP-22 Design and develop computational artifacts working in team roles using collaborative tools',
            'CSTA_3A_AP_23' => '3A-AP-23 Document design decisions using text, graphics, presentations, and/or demonstrations in
             the development of complex programs',
            'CSTA_3B_AP_08' => '3B-AP-08 Describe how artificial intelligence drives many software and physical systems',
            'CSTA_3B_AP_09' => '3B-AP-09 Implement an artificial intelligence algorithm to play a game against a human opponent or
             solve a problem',
            'CSTA_3B_AP_10' => '3B-AP-10 Use and adapt classic algorithms to solve computational problems',
            'CSTA_3B_AP_11' => '3B-AP-11 Evaluate algorithms in terms of their efficiency, correctness, and clarity',
            'CSTA_3B_AP_12' => '3B-AP-12 Compare and contrast fundamental data structures and their uses',
            'CSTA_3B_AP_13' => '3B-AP-13 Illustrate the flow of execution of a recursive algorithm',
            'CSTA_3B_AP_14' => '3B-AP-14 Construct solutions to problems using student-created components, such as procedures,
             modules and/or objects',
            'CSTA_3B_AP_15' => '3B-AP-15 Analyze a large-scale computational problem and identify generalizable patterns that can
             be applied to a solution',
            'CSTA_3B_AP_16' => '3B-AP-16 Demonstrate code reuse by creating programming solutions using libraries and APIs',
            'CSTA_3B_AP_17' => '3B-AP-17 Plan and develop programs for broad audiences using a software life cycle process',
            'CSTA_3B_AP_18' => '3B-AP-18 Explain security issues that might lead to compromised computer programs',
            'CSTA_3B_AP_19' => '3B-AP-19 Develop programs for multiple computing platforms',
            'CSTA_3B_AP_20' => '3B-AP-20 Use version control systems, integrated development environments (IDEs), and
             collaborative tools and practices (code documentation) in a group software project',
            'CSTA_3B_AP_21' => '3B-AP-21 Develop and use a series of test cases to verify that a program performs according to its
             design specifications',
            'CSTA_3B_AP_22' => '3B-AP-22 Modify an existing program to add additional functionality and discuss intended and
             unintended implications (e.g., breaking other functionality)',
            'CSTA_3B_AP_23' => '3B-AP-23 Evaluate key qualities of a program through a process such as a code review',
            'CSTA_3B_AP_24' => '3B-AP-24 Compare multiple programming languages and discuss how their features make them
             suitable for solving different types of problems',
            'CSTA_1A_IC_16' => '1A-IC-16 Compare how people live and work before and after the implementation or adoption of
             new computing technology',
            'CSTA_1A_IC_17' => '1A-IC-17 Work respectfully and responsibly with others online',
            'CSTA_1A_IC_18' => '1A-IC-18 Keep login information private, and log off of devices appropriately',
            'CSTA_1B_IC_18' => '1B-IC-18 Discuss computing technologies that have changed the world, and express how those
             technologies influence, and are influenced by, cultural practices',
            'CSTA_1B_IC_19' => '1B-IC-19 Brainstorm ways to improve the accessibility and usability of technology products for the
             diverse needs and wants of users',
            'CSTA_1B_IC_20' => '1B-IC-20 Seek diverse perspectives for the purpose of improving computational artifacts',
            'CSTA_1B_IC_21' => '1B-IC-21 Use public domain or creative commons media, and refrain from copying or using material
             created by others without permission',
            'CSTA_2_IC_20' => '2-IC-20 Compare tradeoffs associated with computing technologies that affect people\'s everyday
             activities and career options',
            'CSTA_2_IC_21' => '2-IC-21 Discuss issues of bias and accessibility in the design of existing technologies',
            'CSTA_2_IC_22' => '2-IC-22 Collaborate with many contributors through strategies such as crowdsourcing or surveys
             when creating a computational artifact',
            'CSTA_2_IC_23' => '2-IC-23 Describe tradeoffs between allowing information to be public and keeping information
             private and secure',
            'CSTA_3A_IC_24' => '3A-IC-24 Evaluate the ways computing impacts personal, ethical, social, economic, and cultural
             practices',
            'CSTA_3A_IC_25' => '3A-IC-25 Test and refine computational artifacts to reduce bias and equity deficits',
            'CSTA_3A_IC_26' => '3A-IC-26 Demonstrate ways a given algorithm applies to problems across disciplines',
            'CSTA_3A_IC_27' => '3A-IC-27 Use tools and methods for collaboration on a project to increase connectivity of people in
             different cultures and career fields',
            'CSTA_3A_IC_28' => '3A-IC-28 Explain the beneficial and harmful effects that intellectual property laws can have on
             innovation',
            'CSTA_3A_IC_29' => '3A-IC-29 Explain the privacy concerns related to the collection and generation of data through
             automated processes that may not be evident to users',
            'CSTA_3A_IC_30' => '3A-IC-30 Evaluate the social and economic implications of privacy in the context of safety, law, or
             ethics',
            'CSTA_3B_IC_25' => '3B-IC-25 Evaluate computational artifacts to maximize their beneficial effects and minimize harmful
             effects on society',
            'CSTA_3B_IC_26' => '3B-IC-26 Evaluate the impact of equity, access, and influence on the distribution of computing
             resources in a global society',
            'CSTA_3B_IC_27' => '3B-IC-27 Predict how computational innovations that have revolutionized aspects of our culture
             might evolve',
            'CSTA_3B_IC_28' => '3B-IC-28 Debate laws and regulations that impact the development and use of software',
            'NE_CS_HS_1_a' => 'CS.HS.1.a Interpret potential beneficial and harmful effects of computing innovations and emerging technologies, including artificial intelligence',
            'NE_CS_HS_1_b' => 'CS.HS.1.b Identify and explain how hardware components and software application meet the needs of the end user',
            'NE_CS_HS_1_c' => 'CS.HS.1.c Demonstrate effective and efficient searches',
            'NE_CS_HS_1_d' => 'CS.HS.1.d Select and use appropriate software to complete tasks in a variety of educational and professional settings',
            'NE_CS_HS_1_e' => 'CS.HS.1.e Identify information technologies used in various industries and potential careers in those industries',
            'NE_CS_HS_2_a' => 'CS.HS.2.a Examine and evaluate cultrual, social, and ethical issues associated with information technology',
            'NE_CS_HS_2_b' => 'CS.HS.2.b Apply digital literacy by assessing the validity, accuracy, and appropriateness of information',
            'NE_CS_HS_2_c' => 'CS.HS.2.c Describe how algorithms may result in both intentional and unintentional bias',
            'NE_CS_HS_2_d' => 'CS.HS.2.d Investigate how application of computing can have legal implications',
            'NE_CS_HS_2_e' => 'CS.HS.2.e Evaluate safety and security measures for protecting information and managing digital footprints',
            'NE_CS_HS_3_a' => 'CS.HS.3.a Identify and describe computing hardware components',
            'NE_CS_HS_3_b' => 'CS.HS.3.b Perform operations on digital files stored on local devices and remote/cloud storage',
            'NE_CS_HS_3_c' => 'CS.HS.3.c Compare and constrast the functions, features, and limitations of different operating systems and utilities',
            'NE_CS_HS_3_d' => 'CS.HS.3.d Troubleshoot computer hardware and software',
            'NE_CS_HS_3_e' => 'CS.HS.3.e Define components of computer networks',
            'NE_CS_HS_3_f' => 'CS.HS.3.f Explain how data is sent through the internet',
            'NE_CS_HS_3_g' => 'CS.HS.3.g Interpret and draw conclusions based on a data set',
            'NE_CS_HS_4_a' => 'CS.HS.4.a Describe cryptography, encryption, and ciphers',
            'NE_CS_HS_4_b' => 'CS.HS.4.b Identify methods to protect personal devices, information, and systems',
            'NE_CS_HS_4_c' => 'CS.HS.4.c Compare and contrast federal, state, local, and international cybersecurity policies',
            'NE_CS_HS_5_a' => 'CS.HS.5.a Define the term algorithm and explain its relationship to computational solutions',
            'NE_CS_HS_5_b' => 'CS.HS.5.b Decompose a complex problem into distinct parts',
            'NE_CS_HS_5_c' => 'CS.HS.5.c Identify and develop computation solutions to problems',
            'NE_CS_HS_5_d' => 'CS.HS.5.d Define abstraction in terms of computer science and explain how it is used to manage complexity',
            'NE_CS_HS_5_e' => 'CS.HS.5.e Represent equivalent data using different encoding schemes',
            'NE_CS_HS_6_a' => 'CS.HS.6.a Predict the result or output of code execution',
            'NE_CS_HS_6_b' => 'CS.HS.6.b Develop programs that use sequences of statements, variables, loops, and conditionals',
            'NE_CS_HS_6_c' => 'CS.HS.6.c Design and develop computational artifacts that address personally- or socially relavent concerns',
            'NE_CS_HS_6_d' => 'CS.HS.6.d Use abstraction to manage complexity or avoid duplication of effort',
            'NE_CS_HS_6_e' => 'CS.HS.6.e Use existing procedures within a program or language based on documentation',
            'NE_CS_HS_6_f' => 'CS.HS.6.f Write documentation describing the function of computational artifacts',
        ];
    }
}
