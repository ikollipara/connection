<?php

namespace App\Enums;

use Closure;
use Illuminate\Support\Str;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self practice1_1()
 * @method static self practice1_2()
 * @method static self practice1_3()
 * @method static self practice2_1()
 * @method static self practice2_2()
 * @method static self practice2_3()
 * @method static self practice2_4()
 * @method static self practice3_1()
 * @method static self practice3_2()
 * @method static self practice3_3()
 * @method static self practice4_1()
 * @method static self practice4_2()
 * @method static self practice4_3()
 * @method static self practice4_4()
 * @method static self practice5_1()
 * @method static self practice5_2()
 * @method static self practice5_3()
 * @method static self practice6_1()
 * @method static self practice6_2()
 * @method static self practice6_3()
 * @method static self practice7_1()
 * @method static self practice7_2()
 * @method static self practice7_3()
 */
class Practice extends Enum
{
    protected static function values(): Closure
    {
        return fn(string $practice) => Str::of($practice)->substr(8)->replace('_', '.')->__toString();
    }

    protected static function labels()
    {
        return [
            'practice1_1' => '1.1 Include the unique perspectives of others and reflect on one’s own perspectives when designing
            and developing computational products',
            'practice1_2' => '1.2 Address the needs of diverse end users during the design process to produce artifacts with
            broad accessibility and usability',
            'practice1_3' => '1.3 Employ self- and peer-advocacy to address bias in interactions, product design, and development
            methods',
            'practice2_1' => '2.1 Cultivate working relationships with individuals possessing diverse perspectives, skills, and
            personalities',
            'practice2_2' => '2.2 Create team norms, expectations, and equitable workloads to increase efficiency and effectiveness',
            'practice2_3' => '2.3 Solicit and incorporate feedback from, and provide constructive feedback to, team members and
            other stakeholders',
            'practice2_4' => '2.4 Evaluate and select technological tools that can be used to collaborate on a project',
            'practice3_1' => '3.1 Identify complex, interdisciplinary, real-world problems that can be solved computationally',
            'practice3_2' => '3.2 Decompose complex real-world problems into manageable subproblems that could integrate
            existing solutions or procedures',
            'practice3_3' => '3.3 Evaluate whether it is appropriate and feasible to solve a problem computationally',
            'practice4_1' => '4.1 Extract common features from a set of interrelated processes or complex phenomena',
            'practice4_2' => '4.2 Evaluate existing technological functionalities and incorporate them into new designs',
            'practice4_3' => '4.3 Create modules and develop points of interaction that can apply to multiple situations and
            reduce complexity',
            'practice4_4' => '4.4 Model phenomena and processes and simulate systems to understand and evaluate potential
            outcomes',
            'practice5_1' => '5.1 Plan the development of a computational artifact using an iterative process that includes reflection
            on and modification of the plan, taking into account key features, time and resource constraints,
            and user expectations',
            'practice5_2' => '5.2 Create a computational artifact for practical intent, personal expression, or to address a societal
            issue',
            'practice5_3' => '5.3 Modify an existing artifact to improve or customize it',
            'practice6_1' => '6.1 Systematically test computational artifacts by considering all scenarios and using test cases',
            'practice6_2' => '6.2 Identify and fix errors using a systematic process',
            'practice6_3' => '6.3 Evaluate and refine a computational artifact multiple times to enhance its performance, reliability,
            usability, and accessibility',
            'practice7_1' => '7.1 Select, organize, and interpret large data sets from multiple sources to support a claim',
            'practice7_2' => '7.2 Describe, justify, and document computational processes and solutions using appropriate terminology
            consistent with the intended audience and purpose',
            'practice7_3' => '7.3 Articulate ideas responsibly by observing intellectual property rights and giving appropriate
            attribution',
        ];
    }
}
