using Zenject;
using NUnit.Framework;
using System;
using System.Text;
using System.IO;
using Moq;

/// <summary>
/// Hint: Keywords you may need: Mock, Setup, It.IsAny, Returns, Throws, Assert
/// </summary>
[TestFixture]
public class FileCacheStorageTest : ZenjectUnitTestFixture
{
    class AnyException : Exception
    {
    }

    [Test]
    public void Should_Has_ReturnTrue_When_EntryExists()
    {
    }

    [Test]
    public void Should_Has_ReturnFalse_When_EntryDoesntExist()
    {
    }

    [Test]
    public void Should_Has_ReturnFalse_After_DeleteEntry()
    {
    }

    [Test]
    public void Should_MatchesVersion_ReturnFalse_When_EntryHasBadVersion()
    {
    }

    [Test]
    public void Should_MatchesVersion_ReturnTrue_When_EntryHasCorrectVersion()
    {
    }

    [Test]
    public void Should_Get_ReturnValidData_When_EntryExists()
    {
    }

    [Test]
    public void Should_Get_ReturnNull_When_EntryDoesntExist()
    {
    }

    [Test]
    public void Should_Get_ThrowException_When_FileSystemReadThrowsException()
    {
    }

    [Test]
    public void Should_Get_ReturnSameData_ThatWasSet()
    {
    }

    [Test]
    public void Should_Set_ThrowException_When_FileSystemWriteThrowsException()
    {
    }
}