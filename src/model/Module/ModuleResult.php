<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 05/11/2015
 * Time: 22:00
 */

namespace Itb\Model\Module;

/**
 * Class Book to represent book objects
 * @package Itb
 */
class ModuleResult
{
    /**
     * module result ID - auto generated from Database
     * @var integer
     */
    private $id;

    /**
     * Module code
     *
     * example:
     * <code>
     * COMP H6046
     * </code>
     *
     * @var string
     */
    private $moduleCode;

    /**
     * student number 'B' + 8 digits
     *
     * example:
     * <code>
     * B00001234
     * </code>
     *
     * @var string
     */
    private $studentNumber;

    /**
     * alpbetic grade ('A', 'B' etc.)
     *
     * example:
     * <code>
     * A
     * </code>
     *
     * @var string
     */
    private $grade;

    /**
     * date string for module assessmen4t
     *
     * example:
     * <code>
     * 2017_may
     * </code>
     *
     * @var string
     */
    private $semester;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getModuleCode(): string
    {
        return $this->moduleCode;
    }

    /**
     * @param string $moduleCode
     */
    public function setModuleCode(string $moduleCode)
    {
        $this->moduleCode = $moduleCode;
    }

    /**
     * @return string
     */
    public function getStudentNumber(): string
    {
        return $this->studentNumber;
    }

    /**
     * @param string $studentNumber
     */
    public function setStudentNumber(string $studentNumber)
    {
        $this->studentNumber = $studentNumber;
    }

    /**
     * @return string
     */
    public function getGrade(): string
    {
        return $this->grade;
    }

    /**
     * @param string $grade
     */
    public function setGrade(string $grade)
    {
        $this->grade = $grade;
    }

    /**
     * @return string
     */
    public function getSemester(): string
    {
        return $this->semester;
    }

    /**
     * @param string $semester
     */
    public function setSemester(string $semester)
    {
        $this->semester = $semester;
    }

}